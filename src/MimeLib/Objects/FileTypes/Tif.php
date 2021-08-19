<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Tif implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return
                Utilities::checkForBytes($targetFile, [0x49, 0x49, 0x2A, 0x0]) ||
                Utilities::checkForBytes($targetFile, [0x4D, 0x4D, 0x0, 0x2A]);
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType("tif", "image/tiff");
        }
    }