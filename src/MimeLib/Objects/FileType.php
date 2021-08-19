<?php

    namespace MimeLib\Objects;


    class FileType
    {
        /**
         * @var string
         */
        private string $Extension;

        /**
         * @var string
         */
        private string $Mime;

        public function __construct(string $extension, string $mime)
        {
            $this->Extension = $extension;
            $this->Mime = $mime;
        }

        /**
         * @return string
         */
        public function getMime(): string
        {
            return $this->Mime;
        }

        /**
         * @return string
         */
        public function getExtension(): string
        {
            return $this->Extension;
        }
    }