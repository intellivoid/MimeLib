<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Mp4 implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return Utilities::checkForBytes($targetFile, [0x33, 0x67, 0x70, 0x35]) || // 3gp5
                (
                    Utilities::checkForBytes($targetFile, [0x0, 0x0, 0x0]) &&
                    Utilities::checkForBytes($targetFile, [0x66, 0x74, 0x79, 0x70], 4) &&
                    (
                        Utilities::checkForBytes($targetFile, [0x6D, 0x70, 0x34, 0x31], 8) || // MP41
                        Utilities::checkForBytes($targetFile, [0x6D, 0x70, 0x34, 0x32], 8) || // MP42
                        Utilities::checkForBytes($targetFile, [0x69, 0x73, 0x6F, 0x6D], 8) || // ISOM
                        Utilities::checkForBytes($targetFile, [0x69, 0x73, 0x6F, 0x32], 8) || // ISO2
                        Utilities::checkForBytes($targetFile, [0x6D, 0x6D, 0x70, 0x34], 8) || // MMP4
                        Utilities::checkForBytes($targetFile, [0x4D, 0x34, 0x56], 8) || // M4V
                        Utilities::checkForBytes($targetFile, [0x64, 0x61, 0x73, 0x68], 8) // DASH
                    )
                );
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('mp4', 'video/mp4');
        }
    }