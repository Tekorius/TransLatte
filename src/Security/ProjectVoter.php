<?php

namespace App\Security;

use App\Entity\Project;
use App\Entity\ProjectUser;
use App\Entity\User;
use App\Repository\ProjectUserRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjectVoter extends Voter
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

        if (!$subject instanceof Project) {
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

        $project = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($project, $user);

            case self::EDIT:
                return $this->canEdit($project, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Project $project, User $user)
    {
        if (null === $projectUser = $this->projectUserRepo->getProjectUser($project, $user)) {
            return false;
        }

        // Everyone can view if they are added to the project
        return true;
    }

    private function canEdit(Project $project, User $user)
    {
        if (null === $projectUser = $this->projectUserRepo->getProjectUser($project, $user)) {
            return false;
        }

        return in_array($projectUser->getRole(), [
            ProjectUser::ROLE_CREATOR,
            ProjectUser::ROLE_ADMIN,
        ]);
    }
}