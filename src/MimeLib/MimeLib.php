<?php

    namespace MimeLib;

    use MimeLib\Classes\Utilities;
    use MimeLib\Exceptions\BuiltinMapNotFoundException;
    use MimeLib\Exceptions\CannotDetectFileTypeException;
    use MimeLib\Objects\FileType;
    use MimeLib\Objects\TargetFile;

    class MimeLib
    {

        /**
         * The cached built-in mapping array.
         *
         * @var array
         */
        private static $built_in;

        /**
         * The mapping array.
         *
         * @var array
         */
        protected $mapping;

        /**
         * @param null $mapping
         * @throws BuiltinMapNotFoundException
         */
        public function __construct($mapping = null)
        {
            if ($mapping === null)
            {
                $this->mapping = self::getBuiltIn();
            }
            else
            {
                $this->mapping = $mapping;
            }
        }

        /**
         * Get the first MIME type that matches the given file extension.
         *
         * @param string $extension The file extension to check.
         * @return string|null The first matching MIME type or null if nothing matches.
         */
        public function getMimeType(string $extension): ?string
        {
            $extension = $this->cleanInput($extension);
            if (!empty($this->mapping['mimes'][$extension])) {
                return $this->mapping['mimes'][$extension][0];
            }
            return null;
        }

        /**
         * Get the first file extension (without the dot) that matches the given MIME type.
         *
         * @param string $mime_type The MIME type to check.
         * @return string|null The first matching extension or null if nothing matches.
         */
        public function getExtension(string $mime_type): ?string
        {
            $mime_type = $this->cleanInput($mime_type);
            if (!empty($this->mapping['extensions'][$mime_type])) {
                return $this->mapping['extensions'][$mime_type][0];
            }
            return null;
        }

        /**
         * Get all MIME types that match the given extension.
         *
         * @param string $extension The file extension to check.
         * @return array An array of MIME types that match the given extension; can be empty.
         */
        public function getAllMimeTypes(string $extension): array
        {
            $extension = $this->cleanInput($extension);
            if (isset($this->mapping['mimes'][$extension])) {
                return $this->mapping['mimes'][$extension];
            }
            return array();
        }

        /**
         * Get all file extensions (without the dots) that match the given MIME type.
         *
         * @param string $mime_type The MIME type to check.
         * @return array An array of file extensions that match the given MIME type; can be empty.
         */
        public function getAllExtensions(string $mime_type): array
        {
            $mime_type = $this->cleanInput($mime_type);

            if (isset($this->mapping['extensions'][$mime_type]))
            {
                return $this->mapping['extensions'][$mime_type];
            }
            return array();
        }

        /**
         * Get the built-in mapping.
         *
         * @return array The built-in mapping.
         * @throws BuiltinMapNotFoundException
         */
        protected static function getBuiltIn(): array
        {
            if (self::$built_in === null)
            {
                $data_path = __DIR__ . DIRECTORY_SEPARATOR . 'Data' . DIRECTORY_SEPARATOR . 'mime.types.json';

                if(file_exists($data_path) == false)
                    throw new BuiltinMapNotFoundException("The builtin map '$data_path' was not found");

                self::$built_in = json_decode(file_get_contents($data_path), true);
            }
            return self::$built_in;
        }

        /**
         * Normalize the input string using lowercase/trim.
         *
         * @param string $input The string to normalize.
         *
         * @return string The normalized string.
         */
        private function cleanInput(string $input): string
        {
            return strtolower(trim($input));
        }

        /**
         * Attempts to detect the file type with the Libraries method and the builtin method
         *
         * @param string $file_path
         * @param int $max_byte_cache_length
         * @return FileType
         * @throws CannotDetectFileTypeException
         * @throws Exceptions\FileNotFoundException
         * @noinspection PhpFullyQualifiedNameUsageInspection
         */
        public static function detectFileType(string $file_path, int $max_byte_cache_length=4096): FileType
        {
            $file = TargetFile::load($file_path, $max_byte_cache_length);

            /** The order is important! **/

            if(\MimeLib\Objects\FileTypes\Jpg::isType($file))
                return \MimeLib\Objects\FileTypes\Jpg::getFileType();
            if(\MimeLib\Objects\FileTypes\Png::isType($file))
                return \MimeLib\Objects\FileTypes\Png::getFileType();
            if(\MimeLib\Objects\FileTypes\Gif::isType($file))
                return \MimeLib\Objects\FileTypes\Gif::getFileType();
            if(\MimeLib\Objects\FileTypes\Webp::isType($file))
                return \MimeLib\Objects\FileTypes\Webp::getFileType();
            if(\MimeLib\Objects\FileTypes\Flif::isType($file))
                return \MimeLib\Objects\FileTypes\Flif::getFileType();
            if(\MimeLib\Objects\FileTypes\Cr2::isType($file))
                return \MimeLib\Objects\FileTypes\Cr2::getFileType();
            if(\MimeLib\Objects\FileTypes\Tif::isType($file))
                return \MimeLib\Objects\FileTypes\Tif::getFileType();
            if(\MimeLib\Objects\FileTypes\Bmp::isType($file))
                return \MimeLib\Objects\FileTypes\Bmp::getFileType();
            if(\MimeLib\Objects\FileTypes\Jxr::isType($file))
                return \MimeLib\Objects\FileTypes\Jxr::getFileType();
            if(\MimeLib\Objects\FileTypes\Psd::isType($file))
                return \MimeLib\Objects\FileTypes\Psd::getFileType();

            if(\MimeLib\Objects\FileTypes\Zip::isType($file))
            {
                // Check for zip-based files
                if(\MimeLib\Objects\FileTypes\Epub::isType($file))
                    return \MimeLib\Objects\FileTypes\Epub::getFileType();
                if(\MimeLib\Objects\FileTypes\Xpi::isType($file))
                    return \MimeLib\Objects\FileTypes\Xpi::getFileType();
                if(\MimeLib\Objects\FileTypes\Odt::isType($file))
                    return \MimeLib\Objects\FileTypes\Odt::getFileType();
                if(\MimeLib\Objects\FileTypes\Ods::isType($file))
                    return \MimeLib\Objects\FileTypes\Ods::getFileType();

                // The docx, xlsx and pptx file types extend the Office Open XML file format:
                // https://en.wikipedia.org/wiki/Office_Open_XML_file_formats
                $zipHeaderIndex = 0; // The first zip header was already found at index 0
                $oxmlFound = false;
                $type = null;
                $oxmlCTypes = Utilities::toBytes('[Content_Types].xml');
                $oxmlRels = Utilities::toBytes('_rels/.rels');

                do
                {
                    $offset = $zipHeaderIndex + 30;

                    if(!$oxmlFound)
                    {
                        $oxmlFound =
                            Utilities::checkForBytes($file, $oxmlCTypes, $offset) ||
                            Utilities::checkForBytes($file, $oxmlRels, $offset);
                    }

                    if(!$type)
                    {
                        if (Utilities::checkString($file, 'word/', $offset))
                        {
                            $type = \MimeLib\Objects\FileTypes\Docx::getFileType();
                        }
                        elseif (Utilities::checkString($file, 'ppt/', $offset))
                        {
                            $type = \MimeLib\Objects\FileTypes\Pptx::getFileType();
                        }
                        elseif (Utilities::checkString($file, 'xl/', $offset))
                        {
                            $type = \MimeLib\Objects\FileTypes\Xlsx::getFileType();
                        }
                    }

                    if ($oxmlFound && $type)
                    {
                        return $type;
                    }

                    $zipHeaderIndex = Utilities::searchForBytes($file, [0x50, 0x4B, 0x03, 0x04], $offset);
                } while ($zipHeaderIndex !== -1);

                // If all else fails, it's most likely just a zip file.
                return \MimeLib\Objects\FileTypes\Zip::getFileType();
            }

            if(\MimeLib\Objects\FileTypes\Tar::isType($file))
                return \MimeLib\Objects\FileTypes\Tar::getFileType();
            if(\MimeLib\Objects\FileTypes\Rar::isType($file))
                return \MimeLib\Objects\FileTypes\Rar::getFileType();
            if(\MimeLib\Objects\FileTypes\Gz::isType($file))
                return \MimeLib\Objects\FileTypes\Gz::getFileType();
            if(\MimeLib\Objects\FileTypes\Bz2::isType($file))
                return \MimeLib\Objects\FileTypes\Bz2::getFileType();
            if(\MimeLib\Objects\FileTypes\_7z::isType($file))
                return \MimeLib\Objects\FileTypes\_7z::getFileType();
            if(\MimeLib\Objects\FileTypes\Dmg::isType($file))
                return \MimeLib\Objects\FileTypes\Dmg::getFileType();
            if(\MimeLib\Objects\FileTypes\Mp4::isType($file))
                return \MimeLib\Objects\FileTypes\Mp4::getFileType();
            if(\MimeLib\Objects\FileTypes\Mid::isType($file))
                return \MimeLib\Objects\FileTypes\Mid::getFileType();
            if(\MimeLib\Objects\FileTypes\Mkv::isType($file))
                return \MimeLib\Objects\FileTypes\Mkv::getFileType();
            if(\MimeLib\Objects\FileTypes\Webm::isType($file))
                return \MimeLib\Objects\FileTypes\Webm::getFileType();
            if(\MimeLib\Objects\FileTypes\Mov::isType($file))
                return \MimeLib\Objects\FileTypes\Mov::getFileType();
            if(\MimeLib\Objects\FileTypes\Avi::isType($file))
                return \MimeLib\Objects\FileTypes\Avi::getFileType();
            if(\MimeLib\Objects\FileTypes\Wav::isType($file))
                return \MimeLib\Objects\FileTypes\Wav::getFileType();
            if(\MimeLib\Objects\FileTypes\Qcp::isType($file))
                return \MimeLib\Objects\FileTypes\Qcp::getFileType();
            if(\MimeLib\Objects\FileTypes\Ani::isType($file))
                return \MimeLib\Objects\FileTypes\Ani::getFileType();
            if(\MimeLib\Objects\FileTypes\Wmv::isType($file))
                return \MimeLib\Objects\FileTypes\Wmv::getFileType();
            if(\MimeLib\Objects\FileTypes\Mpg::isType($file))
                return \MimeLib\Objects\FileTypes\Mpg::getFileType();
            if(\MimeLib\Objects\FileTypes\_3gp::isType($file))
                return \MimeLib\Objects\FileTypes\_3gp::getFileType();

            // Check for MPEG header at different starting offsets
            for ($offset = 0; ($offset < 2 && $offset < ($file->ByteCacheLength - 16)); $offset++)
            {
                if (
                    Utilities::checkForBytes($file, [0x49, 0x44, 0x33], $offset) || // ID3 header
                    Utilities::checkForBytes($file, [0xFF, 0xE2], $offset, [0xFF, 0xE2]) // MPEG 1 or 2 Layer 3 header
                )
                {
                    return \MimeLib\Objects\FileTypes\Mp3::getFileType();
                }

                // MPEG 1 or 2 Layer 2 header
                if (Utilities::checkForBytes($file, [0xFF, 0xE4], $offset, [0xFF, 0xE4]))
                    return \MimeLib\Objects\FileTypes\Mp2::getFileType();

                // MPEG 2 layer 0 using ADTS
                if (Utilities::checkForBytes($file, [0xFF, 0xF8], $offset, [0xFF, 0xFC]))
                    return \MimeLib\Objects\FileTypes\Mp2::getFileType();

                // MPEG 4 layer 0 using ADTS
                if (Utilities::checkForBytes($file, [0xFF, 0xF0], $offset, [0xFF, 0xFC]))
                    return \MimeLib\Objects\FileTypes\Mp4Audio::getFileType();
            }

            if(\MimeLib\Objects\FileTypes\M4a::isType($file))
                return \MimeLib\Objects\FileTypes\M4a::getFileType();

            if(function_exists('mime_content_type'))
            {
                $results = mime_content_type($file->Path);
                if($results !== false)
                {
                    $MimeLib = new MimeLib();

                    return new FileType($MimeLib->getExtension($results), $results);
                }
            }

            throw new CannotDetectFileTypeException("Cannot detect the given file type");
        }
    }

