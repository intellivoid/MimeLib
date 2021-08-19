<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class M4a implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return (
                Utilities::checkForBytes($targetFile, [0x66, 0x74, 0x79, 0x70, 0x4D, 0x34, 0x41], 4) ||
                Utilities::checkForBytes($targetFile, [0x4D, 0x34, 0x41, 0x20])
            );
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('opus', 'audio/opus');
        }
    }