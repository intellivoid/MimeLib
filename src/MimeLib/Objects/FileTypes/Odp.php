<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Classes\Utilities;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Odp implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {
        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            return Utilities::checkString($targetFile, 'mimetypeapplication/vnd.oasis.opendocument.presentation', 30);
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('odp', 'application/vnd.oasis.opendocument.presentation');
        }
    }