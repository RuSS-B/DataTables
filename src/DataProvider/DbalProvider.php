<?php

/*
 * This file is part of the DataTables Backend package.
 *
 * (c) DataTables Backend <https://github.com/RuSS-B/DataTables>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataTables\DataProvider;

use DataTables\Sort;
use Doctrine\DBAL\Query\QueryBuilder;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
use Closure;

/**
 *  @author Russ Balabanov <russ.developer@gmail.com>
 */
class DbalProvider implements DataProviderInterface
{
    private $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->queryBuilder;
    }

    public function getCountQueryBuilderModifier(): Closure
    {
        return function (QueryBuilder $queryBuilder) {
            $qb = clone $queryBuilder;

            $queryBuilder
                ->resetQueryParts()
                ->select('COUNT(*) as total_count')
                ->from("({$qb})", 'tmp');
        };
    }

    public function applySort(?Sort $sort)
    {
        if ($sort) {
            $this->getQueryBuilder()->orderBy($sort->getCol(), $sort->getDir());
        }
    }

    /**
     * @return array
     */
    public function getAllResults(): array
    {
        return $this->getQueryBuilder()->execute()->fetchAll();
    }

    public function createAdapter(): DoctrineDbalAdapter
    {
        return new DoctrineDbalAdapter($this->getQueryBuilder(), $this->getCountQueryBuilderModifier());
    }
}
