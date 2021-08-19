<?php

    namespace MimeLib\Interfaces;

    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    interface FileTypeDetectionInterface
    {
        /**
         * Runs a check to determine if the target file is the file type
         *
         * @param TargetFile $targetFile
         * @return bool
         */
        public static function isType(TargetFile $targetFile): bool;

        /**
         * Returns the file type object
         *
         * @return FileType
         */
        public static function getFileType(): FileType;
    }