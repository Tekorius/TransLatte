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

    /**
     * Get and assign counts total key counts to files
     *
     * @param TranslationFile[] $files
     * @return array
     */
    public function countForFiles(array $files)
    {
        $res = $this->createQueryBuilder('t')
            ->select('f.id, COUNT(1) as cnt')
            ->where('t.file in (:files)')
            ->join('t.file', 'f')
            ->groupBy('t.file')
            ->setParameter('files', $files)
            ->getQuery()
            ->getScalarResult();

        $cnt = array_combine(
            array_column($res, 'id'),
            array_column($res, 'cnt')
        );

        array_walk($files, function(TranslationFile $f) use ($cnt) {
            $f->setKeyCount('total', $cnt[$f->getId()]);
        });

        return $cnt;
    }
}
