<?php

namespace App\Serializer\Normalizer;

use App\Entity\Translation;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TranslationNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    const DETAILS = 'TRANSLATION_DETAILS';

    use NormalizerAwareTrait;

    /**
     * @param Translation $translation
     * @param null $format
     * @param array $context
     * @return array
     */
    public function normalize($translation, $format = null, array $context = [])
    {
        $details = in_array(self::DETAILS, $context);

        $arr = [
            'id' => $translation->getId(),
            'value' => $translation->getValue(),
            'language' => $translation->getLocale(),
        ];

        if ($details) {
            $arr['description'] = $translation->getDescription();
        }

        return $arr;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Translation;
    }
}