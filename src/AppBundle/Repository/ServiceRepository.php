<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Service;
use Doctrine\ORM\EntityRepository;

class ServiceRepository extends EntityRepository
{
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
