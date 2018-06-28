<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FormErrorNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'errors' => $this->convertFormToArray($object),
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof FormInterface && $data->isSubmitted() && !$data->isValid();
    }

    private function convertFormToArray(FormInterface $data)
    {
        $errors = [];

        $scrapedErrors = [];

        // Scrape errors of this object
        foreach ($data->getErrors() as $error) {
            $scrapedErrors[] = $error->getMessage();
        }

        if (!empty($scrapedErrors)) {
            $errors['_errors'] = $scrapedErrors;
        }

        // Go deeper if needed
        foreach ($data->all() as $child) {
            if ($child instanceof FormInterface) {
                $childErrors = $this->convertFormToArray($child);

                if (!empty($childErrors)) {
                    $errors[$child->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }
}