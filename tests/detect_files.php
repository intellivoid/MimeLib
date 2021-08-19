<?php

    require("ppm");

    import("net.intellivoid.mimelib");

    print("jpg_image => " . \MimeLib\MimeLib::detectFileType(__DIR__ . DIRECTORY_SEPARATOR . "jpg_image.jpg")->getMime() . PHP_EOL);
    print("png_image => " . \MimeLib\MimeLib::detectFileType(__DIR__ . DIRECTORY_SEPARATOR . "png_image.jpg")->getMime() . PHP_EOL);