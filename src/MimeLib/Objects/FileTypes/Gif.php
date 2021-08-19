<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Gif implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return Utilities::checkForBytes($targetFile, [0x47, 0x49, 0x46]);
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('gif', 'image/gif');
        }
    }