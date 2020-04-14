<?php

/**
 * Script for automatic assembling of plugins into zip.
 */

$root = dirname(__FILE__);
$excludeDirs = ['.git', '.github', '.idea'];
$excludeFromZip = ['docs'];

/**
 * This filter excludes from the selection zip-archives and the
 * folders with the name added to array '$excludeFromZip' and
 * contents inside them.
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
        || $file->getExtension() === 'zip'
    ) {
        return false;
    }
    return true;
};

foreach (glob($root . '/*', GLOB_ONLYDIR) as $dirPath) {
    $dirName = basename($dirPath);

    if (!in_array($dirName, $excludeDirs)) {
        $zip = new ZipArchive();
        /** @noinspection SpellCheckingInspection */
        $zipName = sprintf(
            '%s/%s.ocmod.zip',
            $dirPath,
            $dirName
        );

        $zip->open($zipName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true
        || die("Could not create/overwrite archive '$zipName'");
        $zip->setArchiveComment("$dirName plugin")
        || die("Could not set comment to archive '$zipName'");

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
            $relativePathUnixStyle = str_replace('\\', '/', $relativePath);

            switch (is_dir($file)) {
                case false:
                    $zip->addFile($path, $relativePathUnixStyle)
                    || die("Could not add file '$path' to archive '$zipName'");
                    break;

                case true:
                    $zip->addEmptyDir($relativePathUnixStyle)
                    || die("Could not create empty folder '$relativePathUnixStyle' inside archive '$zipName'");
                    break;
            }
        }

        $zip->addFile($root . '/LICENSE', 'LICENSE')
        || die("Could not add plugin license to archive '$zipName'");
        $zip->close()
        || die("Failure occurred while trying to write archive '$zipName'");
    }
}
