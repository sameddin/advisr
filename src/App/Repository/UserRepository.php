<?php
namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class UserRepository extends EntityRepository
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
     * @return PaginationInterface
     */
    public function findAll()
    {
        $page = func_get_arg(0);
        $limit = func_get_arg(1);

        $qb = $this->createQueryBuilder('u');

        return $this->paginator->paginate($qb->getQuery(), $page, $limit);
    }

    /**
     * @param array $array
     * @return User[]
     */
    public function findByEmail(array $array)
    {
        $email = $array['email'];

        return $this
            ->createQueryBuilder('u')
            ->where('LOWER(u.email) = LOWER(:email)')
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User $user
     */
    public function save(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
