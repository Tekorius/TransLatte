<?php

namespace App\Serializer\Normalizer;

use App\Entity\Project;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProjectNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    const DETAILS = 'PROJECT_DETAILS';

    use NormalizerAwareTrait;

    /**
     * @param Project $project
     * @param null $format
     * @param array $context
     * @return array
     */
    public function normalize($project, $format = null, array $context = [])
    {
        $details = in_array(self::DETAILS, $context);

        $arr = [
            'id' => $project->getId(),
            'name' => $project->getName(),
        ];

        if ($details) {
            //$arr['description'] = $translation->getDescription();
        }

        return $arr;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Project;
    }
}