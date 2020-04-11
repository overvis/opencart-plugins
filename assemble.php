<?php

/**
 * Script for automatic assembling of plugins into zip.
 */

$root = dirname(__FILE__);
$excludeDirs = ['.git', '.github', '.idea'];
$excludeFromZip = ['docs'];

/**
 * This filter excludes from the selection the folder with
 * the name added to array '$excludeFromZip' and their contents.
 *
 * @param SplFileInfo $file
 * @param string $key
 * @param RecursiveDirectoryIterator $iterator
 *
 * @return bool
 */
$filter = function (
    SplFileInfo $file,
    string $key,
    RecursiveDirectoryIterator $iterator
) use ($excludeFromZip): bool {
    if (
        $iterator->hasChildren()
        && in_array($file->getFilename(), $excludeFromZip)
    ) {
        return false;
    }
    return true;
};

foreach (glob($root . '/*', GLOB_ONLYDIR) as $dirPath) {
    $dirName = basename($dirPath);

    if (!in_array($dirName, $excludeDirs)) {
        $zip = new ZipArchive();
        $zipName = sprintf(
            '%s/%s.ocmod.zip',
            $dirPath,
            $dirName
        );

        if (file_exists($zipName)) unlink($zipName);

        $zip->open($zipName, ZipArchive::CREATE);
        $zip->setArchiveComment("$dirName plugin") || die("Could not set archive comment");

        $innerIterator = new RecursiveDirectoryIterator(
            $dirPath,
            RecursiveDirectoryIterator::SKIP_DOTS
        );

        $filesToZip = new RecursiveIteratorIterator(
            new RecursiveCallbackFilterIterator(
                $innerIterator,
                $filter
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($filesToZip as $path => $file) {
            $relativePath = substr($path, strlen($dirPath) + 1);

            switch (is_dir($file)) {
                case false:
                    $zip->addFile($path, $relativePath)
                    || die("Could not add file '$path' to archive");
                    break;

                case true:
                    $zip->addEmptyDir($relativePath)
                    || die("Could not create empty folder '$relativePath' inside archive");
                    break;
            }
        }

        $zip->addFile($root . '/LICENSE', 'LICENSE')
        || die("Could not add plugin license to archive");
        $zip->close();
    }
}
