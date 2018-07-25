<?php

namespace App\Controller\Api;

use App\Entity\TranslationFile;
use App\Entity\TranslationKey;
use App\Model\PaginatedRequest;
use App\Security\TranslationFileVoter;
use App\Serializer\Normalizer\TranslationKeyNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @SWG\Tag(name="Translation File")
 * @Route("/translation_files", name="translation_file_")
 */
class TranslationFileController extends Controller
{
    /**
     * Paginated list of translation keys for translation file
     *
     * @SWG\Response(response=200, description="")
     *
     * @Method({"GET"})
     * @Route("/{translationFile}/keys", name="keys")
     */
    public function keys(Request $request, TranslationFile $translationFile)
    {
        $this->denyAccessUnlessGranted(TranslationFileVoter::VIEW, $translationFile);

        $data = $this->getDoctrine()->getRepository(TranslationKey::class)
            ->findByTranslationFile($translationFile, PaginatedRequest::parseRequest($request));

        return $this->json($data);
    }

    /**
     * @SWG\Response(response=200, description="")
     *
     * @Method({"GET"})
     * @Route("/{translationFile}", name="details")
     */
    public function details(TranslationFile $translationFile)
    {
        $this->denyAccessUnlessGranted(TranslationFileVoter::VIEW, $translationFile);

        return $this->json($translationFile, Response::HTTP_OK, [], [
            // TranslationFileNormalizer::DETAILS
        ]);
    }
}