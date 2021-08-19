<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Wav implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return (
                Utilities::checkForBytes($targetFile, [0x52, 0x49, 0x46, 0x46]) &&
                Utilities::checkForBytes($targetFile, [0x57, 0x41, 0x56, 0x45], 8)
            );
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('wav', 'audio/vnd.wave');
        }
    }