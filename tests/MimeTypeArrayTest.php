<?php

namespace ab\Mime;

use PHPUnit\Framework\TestCase;

/**
 * MimeTypeArrayTest
 *
 * @package ab\Mime
 * @author  A.B. Carroll <ben@hl9.net>
 */
class MimeTypeArrayTest extends TestCase
{

    public function testGetContentType()
    {
        $this->assertEquals('text/html', MimeTypeArray::getContentType('html'));
        $this->assertEquals('text/html', MimeTypeArray::getContentType('htm'));
        $this->assertEquals('text/html', MimeTypeArray::getContentType('.html'));
        $this->assertEquals('text/html', MimeTypeArray::getContentType('.htm'));
        $this->assertEquals('text/html', MimeTypeArray::getContentType('.HTML'));
        $this->assertEquals('text/html', MimeTypeArray::getContentType('.htM'));
        $this->assertEquals('text/css', MimeTypeArray::getContentType('.CSS'));
        $this->assertEquals('text/csv', MimeTypeArray::getContentType('.csv'));
        $this->assertEquals('application/javascript', MimeTypeArray::getContentType('js'));
        $this->assertEquals('application/javascript', MimeTypeArray::getContentType('.JS'));
    }
}
