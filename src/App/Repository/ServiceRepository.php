<?php
namespace App\Repository;

use App\Entity\Service;
use Doctrine\ORM\EntityRepository;
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

        $qb = $this->createQueryBuilder('s');

        if (isset($filter['category'])) {
            $qb
                ->andWhere('s.category = :categoryId')
                ->setParameter('categoryId', $filter['category']);
        }

        return $this->paginator->paginate($qb->getQuery(), $page, $limit);
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
