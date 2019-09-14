<?php

/**
 * Script for automatic assembling of plugins into zip
 */

$excludeDirs = ['.git', '.idea'];
$excludeFromZip = ['docs'];

foreach (glob(dirname(__FILE__) . '/*', GLOB_ONLYDIR) as $dirPath) {
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

        /**
         * @param SplFileInfo $file
         * @param mixed $key
         * @param RecursiveCallbackFilterIterator $iterator
         *
         * @return bool
         */
        $filter = function ($file, $key, $iterator) use ($excludeFromZip) {
            if (
                $iterator->hasChildren()
                && !in_array($file->getFilename(), $excludeFromZip)
            ) {
                return true;
            }
            return $file->isFile();
        };

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

        $zip->close();
    }
}
