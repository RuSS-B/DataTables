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

use DataTables\DataProvider\DataProviderInterface;
use Pagerfanta\Pagerfanta;

/**
 *  @author Russ Balabanov <russ.developer@gmail.com>
 */
class PaginationFactory
{
    public function createCollection(DataProviderInterface $dataProvider, Request $request): PaginatedCollection
    {
        $dataProvider->applySort($request->getSort());
        $adapter = $dataProvider->createAdapter();

        if (!$request->getLimit()) {
            //Nothing to do here we just output all the data
            $results = $dataProvider->getAllResults();

            return new PaginatedCollection($results, count($results), $request->getDraw());
        }

        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta
            ->setMaxPerPage($request->getLimit())
            ->setCurrentPage($request->getPage());

        return new PaginatedCollection(
            $pagerfanta->getIterator()->getArrayCopy(),
            $pagerfanta->getNbResults(),
            $request->getDraw()
        );
    }
}
