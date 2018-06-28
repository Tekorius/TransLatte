<?php

namespace App\Controller\Api;
use App\Entity\TranslationKey;
use App\Serializer\Normalizer\TranslationKeyNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @SWG\Tag(name="Translation Keys")
 *
 * @Route("/translation_keys", name="translation_keys_")
 */
class TranslationKeyController extends Controller
{
    /**
     * Get details of the translation key, including values
     *
     * @SWG\Response(response=200, description="")
     *
     * @Method("GET")
     * @Route("/{id}", name="details")
     */
    public function details(TranslationKey $translationKey)
    {
        return $this->json($translationKey, Response::HTTP_OK, [], [
            TranslationKeyNormalizer::DETAILS,
        ]);
    }
}