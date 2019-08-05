<?php

/*
 * This file is part of the DataTables Backend package.
 *
 * (c) DataTables Backend <https://github.com/RuSS-B/DataTables>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataTables;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 *  @author Russ Balabanov <russ.developer@gmail.com>
 */
class Request
{
    const DEFAULT_LIMIT = 25;

    /**
     * @var int
     */
    private $draw;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var Sort|null
     */
    private $sort;

    /**
     * @var ParameterBag
     */
    private $params;

    public function __construct(HttpRequest $request)
    {
        $this->draw   = (int)$request->get('draw');
        $this->limit  = (int)$request->get('length', self::DEFAULT_LIMIT);
        $this->offset = (int)$request->get('start');

        $this->params = new ParameterBag($request->query->all());
        $this->params->set('search', $request->get('search')['value'] ?? null);

        $orderCol = $request->get('order')[0]['column'] ?? null;

        $columns = $request->get('columns');

        if (isset($columns[$orderCol]['name']) && $columns[$orderCol]['name']) {
            $orderColumnName = $columns[$orderCol]['name'];
        } else {
            $orderColumnName = $columns[$orderCol]['data'] ?? null;
        }

        if ($orderColumnName) {
            $this->sort = new Sort($orderColumnName, $request->get('order')[0]['dir'] ?? 'asc');
        }
    }

    public function getDraw(): int
    {
        return $this->draw;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getPage(): int
    {
        return ceil($this->offset / $this->limit) + 1;
    }

    public function getSort(): ?Sort
    {
        return $this->sort;
    }

    public function getParams(): ParameterBag
    {
        return $this->params;
    }
}
