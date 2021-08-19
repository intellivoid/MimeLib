<?php

    require("ppm");
    import("net.intellivoid.mimelib");

    print("jpg_image.jpg => " . \MimeLib\MimeLib::detectFileType(
        __DIR__ . DIRECTORY_SEPARATOR . 'test_files' . DIRECTORY_SEPARATOR . 'jpg_image.jpg')->getMime() . PHP_EOL);
    print("png_image.png => " . \MimeLib\MimeLib::detectFileType(
        __DIR__ . DIRECTORY_SEPARATOR . 'test_files' . DIRECTORY_SEPARATOR .  'png_image.png')->getMime() . PHP_EOL);
    print("archive.7z => " . \MimeLib\MimeLib::detectFileType(
        __DIR__ . DIRECTORY_SEPARATOR . 'test_files' . DIRECTORY_SEPARATOR . 'archive.7z')->getMime() . PHP_EOL);
    print("archive.tar => " . \MimeLib\MimeLib::detectFileType(
        __DIR__ . DIRECTORY_SEPARATOR . 'test_files' . DIRECTORY_SEPARATOR . 'archive.tar')->getMime() . PHP_EOL);
    print("archive.tar.gz => " . \MimeLib\MimeLib::detectFileType(
        __DIR__ . DIRECTORY_SEPARATOR . 'test_files' . DIRECTORY_SEPARATOR . 'archive.tar.gz')->getMime() . PHP_EOL);