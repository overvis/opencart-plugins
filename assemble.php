<?php

/**
 * Script for automatic assembling of plugins into zip
 */

$root = dirname(__FILE__);
$excludeDirs = ['.git', '.idea'];
$excludeFromZip = ['docs'];

/**
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
        && !in_array($file->getFilename(), $excludeFromZip)
    ) {
        return true;
    }
    return $file->isFile();
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

        $innerIterator = new RecursiveDirectoryIterator(
            $dirPath,
            RecursiveDirectoryIterator::SKIP_DOTS
        );

        $filesToZip = new RecursiveIteratorIterator(
            new RecursiveCallbackFilterIterator(
                $innerIterator,
                $filter
            )
        );

        foreach ($filesToZip as $file) {
            if (!is_dir($file)) {
                $filePath = realpath($file);
                $relativePath = substr($filePath, strlen($dirPath) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->addFile($root . '/LICENSE', 'LICENSE');

        $zip->close();
    }
}
