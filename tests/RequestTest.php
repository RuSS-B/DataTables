<?php

namespace DataTables\Tests;

use DataTables\Request as DataTableRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RequestTest extends TestCase
{
    public function testPaginationWithoutParams()
    {
        $data = [];

        $request = new DataTableRequest(Request::create('localhost', 'GET', $data));

        $this->assertEquals(0, $request->getOffset());
        $this->assertEquals(DataTableRequest::DEFAULT_LIMIT, $request->getLimit());
        $this->assertEquals(1, $request->getPage());
    }

    public function testPageNumber()
    {
        $data = [
            'start'  => 40,
            'length' => 10
        ];

        $request = new DataTableRequest(Request::create('localhost', 'GET', $data));

        $this->assertEquals(5, $request->getPage());
    }

    public function testSearch()
    {
        $data = [
            'search' => [
                'regex' => false,
                'value' => 'TEST!'
            ]
        ];

        $request = new DataTableRequest(Request::create('localhost', 'GET', $data));

        $this->assertEquals('TEST!', $request->getParams()->get('search'));
    }

    public function testSort()
    {
        $data = [
            'columns' => [
                [
                    'data' => 'id',
                    'name' => 'The ID',
                ],
            ],
            'order'   => [
                [
                    'column' => 0,
                    'dir'    => 'natural',
                ],
            ],
        ];

        $request = new DataTableRequest(Request::create('localhost', 'GET', $data));

        $this->assertEquals('The ID', $request->getSort()->getCol());
        $this->assertEquals('asc', $request->getSort()->getDir());
    }

    public function testSortWithFallback()
    {
        $data = [
            'columns' => [
                [
                    'data' => 'id',
                    'name' => 'The ID',
                ],
                [
                    'data' => 'name',
                    'name' => null,
                ],
            ],
            'order'   => [
                [
                    'column' => 1,
                    'dir'    => 'natural',
                ],
            ],
        ];

        $request = new DataTableRequest(Request::create('localhost', 'GET', $data));

        $this->assertEquals('name', $request->getSort()->getCol());
        $this->assertEquals('asc', $request->getSort()->getDir());
    }
}
