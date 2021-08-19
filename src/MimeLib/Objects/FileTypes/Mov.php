<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Mov implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return (
                Utilities::checkForBytes($targetFile, [0x0, 0x0, 0x0, 0x14, 0x66, 0x74, 0x79, 0x70, 0x71, 0x74, 0x20, 0x20]) ||
                Utilities::checkForBytes($targetFile, [0x66, 0x72, 0x65, 0x65], 4) ||
                Utilities::checkForBytes($targetFile, [0x66, 0x74, 0x79, 0x70, 0x71, 0x74, 0x20, 0x20], 4) ||
                Utilities::checkForBytes($targetFile, [0x6D, 0x64, 0x61, 0x74], 4) || // MJPEG
                Utilities::checkForBytes($targetFile, [0x6D, 0x6F, 0x6F, 0x76], 4) || // Moov
                Utilities::checkForBytes($targetFile, [0x77, 0x69, 0x64, 0x65], 4)
            );
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('mov', 'video/quicktime');
        }
    }