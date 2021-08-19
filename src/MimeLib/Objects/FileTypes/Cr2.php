<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Cr2 implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return Utilities::checkForBytes($targetFile, [0x43, 0x52], 8) &&
                (
                    Utilities::checkForBytes($targetFile, [0x49, 0x49, 0x2A, 0x0]) ||
                    Utilities::checkForBytes($targetFile, [0x4D, 0x4D, 0x0, 0x2A])
                );
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('cr2', 'image/x-canon-cr2');
        }
    }