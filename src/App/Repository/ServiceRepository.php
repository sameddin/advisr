<?php
namespace App\Repository;

use App\Entity\Service;
use Doctrine\ORM\EntityRepository;

class ServiceRepository extends EntityRepository
{
    /**
     * @param array $filter
     * @return Service[]
     */
    public function findAll(array $filter = [])
    {
        $qb = $this->createQueryBuilder('s');

        if (isset($filter['category'])) {
            $qb
                ->andWhere('s.category = :categoryId')
                ->setParameter('categoryId', $filter['category']);
        }

        return $qb
            ->getQuery()
            ->getResult();
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
