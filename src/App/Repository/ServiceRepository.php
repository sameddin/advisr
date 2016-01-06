<?php
namespace App\Repository;

use App\Entity\Service;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class ServiceRepository extends EntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * @param PaginatorInterface $paginator
     */
    public function setPaginator(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @param array $filter
     * @return PaginationInterface
     */
    public function findAll(array $filter = [])
    {
        $page = func_get_arg(1);
        $limit = func_get_arg(2);

        $qb = $this->getQueryBuilder();
        $this->applyFilter($qb, $filter);

        return $this->paginator->paginate($qb->getQuery(), $page, $limit);
    }

    private function getQueryBuilder()
    {
        return $this
            ->createQueryBuilder('s');
    }

    /**
     * @param QueryBuilder $qb
     * @param array $filter
     */
    private function applyFilter(QueryBuilder $qb, array $filter)
    {
        if (isset($filter['category']) && !empty($filter['category'])) {
            $qb
                ->andWhere('s.category = :categoryId')
                ->setParameter('categoryId', $filter['category']);
        }
    }

    /**
     * @param Service $service
     */
    public function save(Service $service)
    {
        $this->getEntityManager()->persist($service);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Service $service
     */
    public function remove(Service $service)
    {
        $this->getEntityManager()->remove($service);
        $this->getEntityManager()->flush();
    }
}
