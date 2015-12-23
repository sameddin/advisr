<?php
namespace App\Listener;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RawUserPasswordEncoder
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $user = $args->getEntity();
        if ($user instanceof User) {
            $this->encodePassword($user);
        }
    }

    private function encodePassword(User $user)
    {
        if (!$user->getRawPassword()) {
            return;
        }

        $password = $this->passwordEncoder->encodePassword($user, $user->getRawPassword());
        $user->setPassword($password);
    }
}
