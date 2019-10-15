<?php

/**
 * Simple download + conversion for the public domain apache content-type list
 */


if (in_array('--reverse', $argv, true)) {
    fwrite(STDERR, "Running in reverse mode (ext => contentType)\n");
    $xmode = 1;
    $keyName = "File extension";
    $valueName = "content-type";
} elseif (in_array('--array-value', $argv, true)) {
    $xmode = 2;
    $keyName = "Content-type";
    $valueName = "file extension";
} else {
    $xmode = 0;
    $keyName = "Content-type";
    $valueName = "file extension";
}


$types = file("https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types");
$buildTable = [];
foreach ($types as $typeLine) {
    if (substr($typeLine, 0, 1) !== '#') {
        [$contentType, $fileExtensionList] = preg_split('/\s+/', $typeLine, 2);
        $fileExtensionList = trim($fileExtensionList);
        $fileExtensionList = explode(" ", $fileExtensionList);

        if ($xmode === 2) {
            $buildTable[$contentType] = $fileExtensionList;
        } else {
            foreach ($fileExtensionList as $ext) {
                if ($xmode) {
                    $key = $ext;
                    $value = $contentType;
                } else {
                    $key = $contentType;
                    $value = $ext;
                }

                if (!isset($buildTable[$key])) {
                    $buildTable[$key] = $value;
                } else {
                    $previousType = $buildTable[$key];
                    fwrite(
                        STDERR,
                        "Warning: $keyName maps to more than one $valueName: $key (maps to $previousType as well as $value)\n"
                    );
                }
            }
        }
    }
}

if (in_array('--reverse', $argv, true)) {
    fwrite(STDERR, "Flipping array\n");
    $buildTable = array_flip($buildTable);
}

if (in_array('--json-pretty', $argv)) {
    echo json_encode($buildTable, JSON_PRETTY_PRINT);
} elseif (in_array('--json', $argv)) {
    echo json_encode($buildTable);
} else {
    echo '<?php return ';
    var_export($buildTable);
    echo ';';
}
