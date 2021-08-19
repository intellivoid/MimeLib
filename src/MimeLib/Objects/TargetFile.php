<?php

    namespace MimeLib\Objects;

    use MimeLib\Exceptions\FileNotFoundException;

    class TargetFile
    {
        /**
         * The hash of the given file
         *
         * @var string
         */
        public $Hash;

        /**
         * The path to the given file
         *
         * @var string
         */
        public $Path;

        /**
         * Maximum number of bytes to cache
         *
         * @var int
         */
        public $MaxByteCacheLength;

        /**
         * Number of cached bytes
         *
         * @var int
         */
        public $ByteCacheLength;

        /**
         * Cached first X bytes of the given file
         *
         * @var array
         */
        public $ByteCache;


        public function __construct()
        {
            $this->ByteCache = [];
            $this->ByteCacheLength = 0;
            $this->MaxByteCacheLength = 4096;
            $this->Path = null;
            $this->Hash = null;
        }

        /**
         * Loads a file partially into memory
         *
         * @param string $path
         * @param int $max_byte_cache_length
         * @return TargetFile
         * @throws FileNotFoundException
         */
        public static function load(string $path, int $max_byte_cache_length=4096): TargetFile
        {
            if(file_exists($path) == false)
                throw new FileNotFoundException('The file \'$path\' does not exist');

            $TargetFileObject = new TargetFile();

            $TargetFileObject->Path = $path;
            $TargetFileObject->MaxByteCacheLength = $max_byte_cache_length;
            $TargetFileObject->Hash = hash_file('crc32b', $path);

            // Get the first length of bytes
            $handler = fopen($TargetFileObject->Path, 'rb');
            $data = fread($handler, $TargetFileObject->MaxByteCacheLength);
            fclose($handler);

            foreach(str_split($data) as $i => $char)
            {
                $TargetFileObject->ByteCache[$i] = ord($char);
            }

            $TargetFileObject->ByteCacheLength = count($TargetFileObject->ByteCache);

            return $TargetFileObject;
        }
    }