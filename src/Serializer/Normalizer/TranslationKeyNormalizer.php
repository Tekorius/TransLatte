<?php

namespace App\Serializer\Normalizer;

use App\Entity\TranslationKey;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TranslationKeyNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    const DETAILS = 'TRANSLATION_KEY_DETAILS';

    use NormalizerAwareTrait;

    /**
     * @param TranslationKey $translationKey
     * @param null $format
     * @param array $context
     * @return array
     */
    public function normalize($translationKey, $format = null, array $context = [])
    {
        $details = in_array(self::DETAILS, $context);

        $arr = [
            'id' => $translationKey->getId(),
            'name' => $translationKey->getName(),
        ];

        if ($details) {
            $arr['description'] = $translationKey->getDescription();
        }

        return $arr;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof TranslationKey;
    }
}