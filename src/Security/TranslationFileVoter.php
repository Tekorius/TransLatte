<?php

namespace App\Security;

use App\Entity\ProjectUser;
use App\Entity\TranslationFile;
use App\Entity\User;
use App\Repository\ProjectUserRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TranslationFileVoter extends Voter
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

        if (!$subject instanceof TranslationFile) {
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

        $translationFile = $subject;

        switch ($attribute) {
            case self::CREATE:
                return $this->canCreate($translationFile, $user);

            case self::VIEW:
                return $this->canView($translationFile, $user);

            case self::EDIT:
                return $this->canEdit($translationFile, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canCreate(TranslationFile $translationFile, User $user)
    {
        if (null === $projectUser = $this->getProjectUser($translationFile, $user)) {
            return false;
        }

        return in_array($projectUser->getRole(), [
            ProjectUser::ROLE_CREATOR,
            ProjectUser::ROLE_ADMIN,
        ]);
    }

    private function canView(TranslationFile $translationFile, User $user)
    {
        if (null === $projectUser = $this->getProjectUser($translationFile, $user)) {
            return false;
        }

        // Everyone can view if they are added to the project
        return true;
    }

    private function canEdit(TranslationFile $translationFile, User $user)
    {
        if (null === $projectUser = $this->getProjectUser($translationFile, $user)) {
            return false;
        }

        return in_array($projectUser->getRole(), [
            ProjectUser::ROLE_CREATOR,
            ProjectUser::ROLE_ADMIN,
        ]);
    }

    private function getProjectUser(TranslationFile $translationFile, User $user)
    {
        $project = $translationFile->getProject();
        return $this->projectUserRepo->getProjectUser($project, $user);
    }
}