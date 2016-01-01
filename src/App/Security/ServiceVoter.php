<?php
namespace App\Security;

use App\Entity\Service;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ServiceVoter extends Voter
{
    const ADD = 'add';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [
            self::ADD,
            self::EDIT,
            self::DELETE,
        ])
        ) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $service = $subject;

        switch ($attribute) {
            case self::ADD:
                return $this->canAdd();
            case self::EDIT:
                return $this->canEdit($service, $user);
            case self::DELETE:
                return $this->canDelete($service, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canAdd()
    {
        return true;
    }

    private function canEdit(Service $service, User $user)
    {
        return $user === $service->getUser();
    }

    private function canDelete(Service $service, User $user)
    {
        return $user === $service->getUser();
    }
}
