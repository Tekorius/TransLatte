<?php

namespace App\Security;

use App\Entity\ProjectUser;
use App\Entity\TranslationKey;
use App\Entity\User;
use App\Repository\ProjectUserRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TranslationKeyVoter extends Voter
{
    const CREATE = 'create';
    const VIEW = 'view';
    const EDIT = 'edit';


    private $projectUserRepo;


    public function __construct(ProjectUserRepository $projectUserRepository)
    {
        $this->projectUserRepo = $projectUserRepository;
    }


    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [
            self::CREATE,
            self::VIEW,
            self::EDIT,
        ])) {
            return false;
        }

        if (!$subject instanceof TranslationKey) {
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

        $translationKey = $subject;

        switch ($attribute) {
            case self::CREATE:
                return $this->canCreate($translationKey, $user);

            case self::VIEW:
                return $this->canView($translationKey, $user);

            case self::EDIT:
                return $this->canEdit($translationKey, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canCreate(TranslationKey $translationKey, User $user)
    {
        if (null === $projectUser = $this->getProjectUser($translationKey, $user)) {
            return false;
        }

        return in_array($projectUser->getRole(), [
            ProjectUser::ROLE_CREATOR,
            ProjectUser::ROLE_ADMIN,
            ProjectUser::ROLE_DEVELOPER,
        ]);
    }

    private function canView(TranslationKey $translationKey, User $user)
    {
        if (null === $projectUser = $this->getProjectUser($translationKey, $user)) {
            return false;
        }

        // Everyone can view if they are added to the project
        return true;
    }

    private function canEdit(TranslationKey $translationKey, User $user)
    {
        if (null === $projectUser = $this->getProjectUser($translationKey, $user)) {
            return false;
        }

        return in_array($projectUser->getRole(), [
            ProjectUser::ROLE_CREATOR,
            ProjectUser::ROLE_ADMIN,
            ProjectUser::ROLE_DEVELOPER,
        ]);
    }

    private function getProjectUser(TranslationKey $translationKey, User $user)
    {
        $project = $translationKey->getFile()->getProject();
        return $this->projectUserRepo->getProjectUser($project, $user);
    }
}