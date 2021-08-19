<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Rar implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return
                isset($targetFile->ByteCache[6]) &&
                (
                    $targetFile->ByteCache[6] === 0x0 ||
                    $targetFile->ByteCache[6] === 0x1
                ) &&
                Utilities::checkForBytes($targetFile, [0x52, 0x61, 0x72, 0x21, 0x1A, 0x7]);
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('rar', 'application/x-rar-compressed');
        }
    }