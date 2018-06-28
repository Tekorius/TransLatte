<?php

namespace App\Repository;

use App\Entity\Translation;
use App\Entity\TranslationKey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Translation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Translation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Translation[]    findAll()
 * @method Translation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Translation::class);
    }


    /**
     * Get a single translation by key and language
     *
     * @param TranslationKey $translationKey
     * @param string $locale
     * @return Translation|null
     */
    public function getByKeyAndLocale(TranslationKey $translationKey, string $locale)
    {
        return $this->findOneBy([
            'translationKey' => $translationKey,
            'locale' => $locale,
        ]);
    }
}
