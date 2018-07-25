<?php

namespace App\Serializer\Normalizer;

use App\Entity\TranslationFile;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TranslationFileNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    const DETAILS = 'TRANSLATION_FILE_DETAILS';
    const KEY_COUNTS = 'TRANSLATION_FILE_KEY_COUNTS';

    use NormalizerAwareTrait;

    /**
     * @param TranslationFile $translationFile
     * @param null $format
     * @param array $context
     * @return array
     */
    public function normalize($translationFile, $format = null, array $context = [])
    {
        $details = in_array(self::DETAILS, $context);
        $keyCounts = in_array(self::KEY_COUNTS, $context);

        $arr = [
            'id' => $translationFile->getId(),
            'name' => $translationFile->getName(),
        ];

        if ($keyCounts) {
            $arr['keyCount'] = $translationFile->getKeyCount();
        }

//        if ($details) {
//            $arr['description'] = $translationKey->getDescription();
//            $arr['translations'] = $this->normalizeTranslations($translationKey, $format, $context);
//        }

        return $arr;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof TranslationFile;
    }
}