<?php

namespace DataTables\Tests;

use DataTables\Sort;
use PHPUnit\Framework\TestCase;

class SortTest extends TestCase
{
    public function testDefaultDir()
    {
        $sort = new Sort('theCol', null);

        $this->assertEquals('asc', $sort->getDir());
    }

    public function testUnknownDir()
    {
        $sort = new Sort('theCol', 'unknown');

        $this->assertEquals('asc', $sort->getDir());
    }

    public function testDescDir()
    {
        $sort = new Sort('theCol', 'desc');

        $this->assertEquals('desc', $sort->getDir());
    }
}
