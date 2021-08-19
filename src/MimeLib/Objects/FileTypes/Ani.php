<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Ani implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return (
                Utilities::checkForBytes($targetFile, [0x52, 0x49, 0x46, 0x46]) &&
                Utilities::checkForBytes($targetFile, [0x41, 0x43, 0x4F, 0x4E], 8)
            );
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('ani', 'application/x-navi-animation');
        }
    }