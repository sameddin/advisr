<?php
namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     */
    public function save(User $user)
    {
        $this->encoderRawPassword($user);

        $this->userRepository->save($user);
    }

    /**
     * @param User $user
     */
    private function encoderRawPassword(User $user)
    {
        if (!$user->getRawPassword()) {
            return;
        }

        $password = $this->passwordEncoder->encodePassword($user, $user->getRawPassword());
        $user->setPassword($password);
    }
}
