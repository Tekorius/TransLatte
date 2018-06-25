<?php

namespace App\Serializer\Normalizer;

use App\Model\PaginatedResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaginatedResponseNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param PaginatedResponse $response
     * @param null $format
     * @param array $context
     * @return array
     */
    public function normalize($response, $format = null, array $context = [])
    {
        return [
            'currentPage' => $response->getCurrentPage(),
            'pages' => $response->getPages(),
            'count' => $response->getCount(),
            'data' => array_map(
                function ($object) use ($format, $context) {
                    return $this->normalizer->normalize($object, $format, $context);
                },
                $response->getData()
            ),
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof PaginatedResponse;
    }
}