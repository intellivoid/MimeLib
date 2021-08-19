<?php

    namespace MimeLib\Classes;

    use MimeLib\Interfaces\FileTypeDetectionInterface;
    use MimeLib\Objects\FileTypes\Jpg;
    use MimeLib\Objects\TargetFile;

    class Utilities
    {
        /**
         * Checks for the given byte sequence, if found it will return true.
         *
         * @param TargetFile $targetFile
         * @param array $bytes
         * @param int $offset
         * @param array $mask
         * @return bool
         */
        public static function checkForBytes(TargetFile $targetFile, array $bytes, int $offset = 0, array $mask = []): bool
        {
            $bytes = array_values($bytes);

            foreach ($bytes as $i => $byte)
            {
                if (!empty($mask))
                {
                    if (!isset($targetFile->byteCache[$offset + $i], $mask[$i]) || $byte !== ($mask[$i] & $targetFile->byteCache[$offset + $i]))
                    {
                        return false;
                    }
                }
                elseif (!isset($targetFile->byteCache[$offset + $i]) || $targetFile->byteCache[$offset + $i] !== $byte)
                {
                    return false;
                }
            }

            return true;
        }

        /**
         * Returns the offset to the next position of the given byte sequence
         * Returns -1 if the sequence was not found.
         *
         * @param TargetFile $targetFile
         * @param array $bytes
         * @param int $offset
         * @param array $mask
         * @return int
         */
        public static function searchForBytes(TargetFile $targetFile, array $bytes, int $offset = 0, array $mask = []): int
        {
            $limit = $targetFile->ByteCacheLength - count($bytes);

            for ($i = $offset; $i < $limit; $i++)
            {
                if (self::checkForBytes($targetFile, $bytes, $i, $mask))
                {
                    return $i;
                }
            }

            return -1;
        }

        /**
         * Returns the byte sequence of the given string
         *
         * @param string $str
         * @return array
         */
        public static function toBytes(string $str): array
        {
            return array_values(unpack('C*', $str));
        }

        /**
         * Checks the byte sequence of a given string.
         *
         * @param TargetFile $targetFile
         * @param string $str
         * @param int $offset
         * @return bool
         */
        public static function checkString(TargetFile $targetFile, string $str, int $offset=0): bool
        {
            return self::checkForBytes($targetFile, self::toBytes($str), $offset);
        }

    }