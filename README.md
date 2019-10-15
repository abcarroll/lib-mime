# lib-mime
An extremely lightweight mostly static mime, content-type and file extension library

## Install

```
composer require ab/lib-mime
```

## Use

An example router script to pass through resources:

```php
use ab\Mime\MimeTypeArray;

(function () {
        $tryPath = $_SERVER['REQUEST_URI'];
        $filename = basename($tryPath);
        [$fileext,] = explode('.', strrev($filename), 2);
        $fileext = strrev($fileext);
                    
	      // .... 

        $type = MimeTypeArray::getContentType($fileext);
        if ($type !== null) {
            header("Content-Type: $type", true);
        } else {
            header("Content-Type: application/octet-stream", true);
        }
                    
        // ...
}());

```

## License

Released under the "Unlicense", which is public domain.  Read more at <https://unlicense.org>.

[Uses the "mime.types" file Provided By The Apache Project](https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types)

