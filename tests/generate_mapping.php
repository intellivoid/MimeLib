<?php
    require("ppm");
    import("net.intellivoid.mimelib");

    $mime_types = file_get_contents("http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types");
    $Generator = new \MimeLib\Classes\MimeMappingGenerator($mime_types);
    $results = $Generator->generateMapping();

    file_put_contents('mime.types.json', json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));