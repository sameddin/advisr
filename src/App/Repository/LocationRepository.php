<?php
namespace App\Repository;

use App\Entity\Location;
use Doctrine\ORM\EntityManager;

class LocationRepository
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return Location[]
     */
    public function findUsed()
    {
        return $this->em
            ->createQuery("
                SELECT l
                FROM App:LOCATION l
                WHERE EXISTS (
                    SELECT 1
                    FROM App:Service s
                    WHERE l MEMBER OF s.locations
                )
                ORDER BY l.name
            ")
            ->getResult();
    }
}
