<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Epub implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return Utilities::checkForBytes($targetFile, [
                0x6D, 0x69, 0x6D, 0x65, 0x74, 0x79, 0x70,
                0x65, 0x61, 0x70, 0x70, 0x6C, 0x69, 0x63,
                0x61, 0x74, 0x69, 0x6F, 0x6E, 0x2F, 0x65,
                0x70, 0x75, 0x62, 0x2B, 0x7A, 0x69, 0x70
            ], 30);
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('epub', 'application/epub+zip');
        }
    }