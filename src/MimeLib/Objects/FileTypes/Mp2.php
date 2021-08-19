<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Exceptions\MethodNotApplicableException;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Mp2 implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            throw new MethodNotApplicableException("Cannot determine the target file type without scanning the mpeg header first");
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('mp2', 'audio/mpeg');
        }
    }