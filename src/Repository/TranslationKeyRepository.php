<?php

namespace App\Repository;

use App\Entity\TranslationFile;
use App\Entity\TranslationKey;
use App\Model\PaginatedRequest;
use App\Model\PaginatedResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TranslationKey|null find($id, $lockMode = null, $lockVersion = null)
 * @method TranslationKey|null findOneBy(array $criteria, array $orderBy = null)
 * @method TranslationKey[]    findAll()
 * @method TranslationKey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationKeyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TranslationKey::class);
    }


    public function findByTranslationFile(TranslationFile $translationFile, PaginatedRequest $request)
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.file = :translationFile')
            ->setParameter('translationFile', $translationFile)
        ;

        return PaginatedResponse::newInstance($request, $qb);
    }
}
