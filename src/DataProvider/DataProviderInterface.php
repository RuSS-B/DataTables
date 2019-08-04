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

/**
 *  @author Russ Balabanov <russ.developer@gmail.com>
 */
interface DataProviderInterface
{
    public function getQueryBuilder();

    public function getCountQueryBuilderModifier();

    public function createAdapter();

    public function applySort(?Sort $sort);

    public function getAllResults();
}
