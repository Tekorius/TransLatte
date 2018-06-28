<?php

namespace App\Security;

use App\Entity\ProjectUser;
use App\Entity\Translation;
use App\Entity\User;
use App\Repository\ProjectUserRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TranslationVoter extends Voter
{
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
            self::VIEW,
            self::EDIT,
        ])) {
            return false;
        }

        if (!$subject instanceof Translation) {
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

        $translation = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($translation, $user);

            case self::EDIT:
                return $this->canEdit($translation, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Translation $translation, User $user)
    {
        if (null === $projectUser = $this->getProjectUser($translation, $user)) {
            return false;
        }

        // Everyone can view if they are added to the project
        return true;
    }

    private function canEdit(Translation $translation, User $user)
    {
        if (null === $projectUser = $this->getProjectUser($translation, $user)) {
            return false;
        }

        return in_array($projectUser->getRole(), [
            ProjectUser::ROLE_CREATOR,
            ProjectUser::ROLE_ADMIN,
            ProjectUser::ROLE_DEVELOPER,
            ProjectUser::ROLE_TRANSLATOR,
        ]);
    }

    private function getProjectUser(Translation $translation, User $user)
    {
        $project = $translation->getTranslationKey()->getFile()->getProject();
        return $this->projectUserRepo->getProjectUser($project, $user);
    }
}