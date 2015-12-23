<?php
namespace App\Manager;

use App\Entity\Service;
use App\Repository\ServiceRepository;

class ServiceManager
{
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    /**
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @param $filter
     * @return Service[]
     */
    public function findAll($filter): array
    {
        return $this->serviceRepository->findAll($filter);
    }

    /**
     * @param Service $service
     */
    public function save(Service $service)
    {
        $this->serviceRepository->save($service);
    }

    /**
     * @param Service $service
     */
    public function remove(Service $service)
    {
        $this->serviceRepository->remove($service);
    }
}
