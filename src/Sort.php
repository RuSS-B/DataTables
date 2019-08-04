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

/**
 *  @author Russ Balabanov <russ.developer@gmail.com>
 */
class Sort
{
    /**
     * @var string
     */
    private $col;

    /**
     * @var string
     */
    private $dir;

    public function __construct(string $col, ?string $dir)
    {
        $this->col = $col;

        if (!$dir) {
            $dir = 'asc';
        }

        $dir = strtolower($dir);
        $this->dir = in_array($dir, ['asc', 'desc']) ? $dir : 'asc';
    }

    public function getCol(): string
    {
        return $this->col;
    }

    public function getDir(): string
    {
        return $this->dir;
    }
}
