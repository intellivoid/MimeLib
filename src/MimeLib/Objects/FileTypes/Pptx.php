<?php

    namespace MimeLib\Objects\FileTypes;

    use MimeLib\Exceptions\MethodNotApplicableException;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class Pptx implements \MimeLib\Interfaces\FileTypeDetectionInterface
    {

        /**
         * @inheritDoc
         */
        public static function isType(TargetFile $targetFile): bool
        {
            throw new MethodNotApplicableException("Cannot determine the target file type without scanning the zip header first");
        }

        /**
         * @inheritDoc
         */
        public static function getFileType(): FileType
        {
            return new FileType('pptx', 'application/vnd.openxmlformats-officedocument.presentationml.presentation');
        }
    }