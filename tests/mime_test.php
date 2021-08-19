<?php

    require("ppm");
    import("net.intellivoid.mimelib");

    $MimeLib = new \MimeLib\MimeLib();

    print('exe => ' . $MimeLib->getMimeType('exe') . PHP_EOL);
    print('application/gzip => ' . $MimeLib->getExtension('application/gzip') . PHP_EOL);