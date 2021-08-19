<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Mkv implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            if(Utilities::checkForBytes($targetFile, [0x1A, 0x45, 0xDF, 0xA3]))
            {
                $idPos = Utilities::checkForBytes($targetFile, [0x42, 0x82]);

                if($idPos != -1 && Utilities::checkString($targetFile, 'matroska', $idPos + 3))
                    return true;
            }

            return false;
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('mkv', 'video/x-matroska');
        }
    }