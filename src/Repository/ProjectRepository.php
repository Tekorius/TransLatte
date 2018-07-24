<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }


    /**
     * Find all projects assigned to the user
     *
     * @param User $user
     * @return Project[]
     */
    public function findUserProjects(User $user)
    {
        return $this->createQueryBuilder('t')
            ->select('t, pu')
            ->join('t.projectUsers', 'pu')
            ->where('pu.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
