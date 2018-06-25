<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\ProjectUser;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProjectUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectUser[]    findAll()
 * @method ProjectUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProjectUser::class);
    }


    /**
     * Check whether provided user has been added to the project
     *
     * @param Project $project
     * @param User $user
     * @return ProjectUser|null
     */
    public function getProjectUser(Project $project, User $user)
    {
        $projectUser = $this->findOneBy([
            'project' => $project,
            'user' => $user,
        ]);

        return $projectUser;
    }
}
