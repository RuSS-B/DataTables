# DataTables Backend
PHP Library to process backend requests from DataTables.js plugin

## Examples

### The controller

```
use DataTables\PaginationFactory;
use DataTables\DataProvider\DbalProvider;
use DataTables\Request as DataTableRequest;

/**
 * @param Request $request
 * @param PaginationFactory $paginationFactory
 * @param RoleModel $roleModel
 *
 * @Route("/my-awesome-url")
 *
 * @return JsonResponse
 */
public function data(Request $request, PaginationFactory $paginationFactory, SomeFancyRepository $someFancyRepository): JsonResponse
{
    $request    = new DataTableRequest($request);
    $collection = $paginationFactory->createCollection(
        new DbalProvider(([$someFancyRepository, 'getQueryBuilder'])($request->getParams())),
        $request
    );

    return $this->json($collection);
}
```

### The Repository / Model

```
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class SomeFancyRepository extends ServiceEntityRepository
{
    public function getQueryBuilder(ParameterBag $params) : QueryBuilder
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();

        $qb
            ->select('stn.id', 'stn.name', 'COUNT(stn.id) AS total')
            ->from('some_table_name', 'stn')
            ->where('stn.name <> :someParam')
            ->groupBy('stn.group_id')
            ->setParameters([
                'someParam' => 'Foo'
            ])
        ;

        if ($search = $params->get('search')) {
            $qb
                ->andWhere($qb->expr()->like('stn.name', ':search'))
                ->setParameter('search', "%{$search}%");
        }

        return $qb;
    }
}
```


### I'd love to get support from you!
Happy with the library? Feel free to smash the **Star** button! This will give me much more motivation to improve this library
