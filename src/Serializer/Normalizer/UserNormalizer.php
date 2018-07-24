<?php

namespace App\Serializer\Normalizer;

use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    const DETAILS = 'USER_DETAILS';

    use NormalizerAwareTrait;

    /**
     * @param User $user
     * @param null $format
     * @param array $context
     * @return array
     */
    public function normalize($user, $format = null, array $context = [])
    {
        $details = in_array(self::DETAILS, $context);

        $arr = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
        ];

        if ($details) {
            //$arr['description'] = $translation->getDescription();
        }

        return $arr;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof User;
    }
}