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

use Closure;
use JsonSerializable;

/**
 *  @author Russ Balabanov <russ.developer@gmail.com>
 */
class PaginatedCollection implements JsonSerializable
{
    /**
     * @var array
     */
    private $items;

    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $draw;

    public function __construct(array $items, int $total, int $draw)
    {
        $this->items = $items;
        $this->total = $total;
        $this->count = count($items);
        $this->draw = $draw;
    }

    public function normalize(Closure $closure)
    {
        foreach ($this->items as $key => $item) {
            $this->items[$key] = $closure($item);
        }
    }

    public function getDraw(): ?int
    {
        return $this->draw;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function jsonSerialize(): array
    {
        return [
            'draw'            => $this->getDraw(),
            'recordsTotal'    => $this->getTotal(),
            'recordsFiltered' => $this->getTotal(),
            'data'            => $this->getItems(),
        ];
    }
}
