<?php
namespace App\Manager;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;

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
     * @param int $page
     * @param int $limit
     * @return PaginationInterface
     */
    public function findAll($filter, $page, $limit): PaginationInterface
    {
        return $this->serviceRepository->findAll($filter, $page, $limit);
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
