<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\TranslationFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TranslationFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method TranslationFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method TranslationFile[]    findAll()
 * @method TranslationFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationFileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TranslationFile::class);
    }


    /**
     * Find all translation files in the project
     *
     * @param Project $project
     * @return TranslationFile[]
     */
    public function findByProject(Project $project)
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.project = :project')
            ->setParameter('project', $project)
            ->getQuery()
            ->getResult();
    }
}
