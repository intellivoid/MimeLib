<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Mpg implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return
                Utilities::checkForBytes($targetFile, [0x0, 0x0, 0x1, 0xBA]) ||
                Utilities::checkForBytes($targetFile, [0x0, 0x0, 0x1, 0xB3]);
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('mpg', 'video/mpeg');
        }
    }