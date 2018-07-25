<?php

namespace App\Repository;

use App\Entity\Translation;
use App\Entity\TranslationFile;
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

    /**
     * @param TranslationFile[] $files
     * @return array
     */
    public function countForFiles(array $files)
    {
        // Fetch counts by different locale
        $res = $this->createQueryBuilder('t')
            ->select('f.id, t.locale, COUNT(1) cnt')
            ->join('t.translationKey', 'k')
            ->join('k.file', 'f')
            ->where('f in (:files)')
            ->groupBy('t.locale')
            ->setParameter('files', $files)
            ->getQuery()
            ->getScalarResult();

        // Merge counts into a nice associative array
        $cnt = [];

        foreach ($res as $re) {
            $cnt[$re['id']][$re['locale']] = $re['cnt'];
        }

        // Assign counts to files
        array_walk($files, function(TranslationFile $file) use ($cnt) {
            if (isset($cnt[$file->getId()])) {
                foreach ($cnt[$file->getId()] as $lang => $count) {
                    $file->setKeyCount($lang, $count);
                }
            }
        });

        return $cnt;
    }
}
