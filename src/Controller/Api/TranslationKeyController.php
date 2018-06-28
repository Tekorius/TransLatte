<?php

namespace App\Controller\Api;
use App\Entity\TranslationKey;
use App\Form\TranslationKeyForm;
use App\Security\TranslationKeyVoter;
use App\Serializer\Normalizer\TranslationKeyNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
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
     * Create a new translation key
     *
     * @SWG\Response(response=200, description="")
     *
     * @Method("POST")
     * @Route("", name="create")
     */
    public function create(Request $request)
    {
        $translationKey = new TranslationKey();

        $form = $this->createPostForm(TranslationKeyForm::class, $translationKey);
        $this->formParseRequest($request, $form);

        if ($form->isValid()) {
            $this->denyAccessUnlessGranted(TranslationKeyVoter::EDIT, $translationKey);

            $em = $this->getDoctrine()->getManager();
            $em->persist($translationKey);
            $em->flush();

            return $this->json($translationKey, Response::HTTP_CREATED, [], [
                TranslationKeyNormalizer::DETAILS,
            ]);
        }

        return $this->formError($form);
    }

    /**
     * Edit an existing translation key
     *
     * @SWG\Response(response=200, description="")
     *
     * @Method("PUT")
     * @Route("/{id}", name="edit")
     */
    public function edit(Request $request, TranslationKey $translationKey)
    {
        $this->denyAccessUnlessGranted(TranslationKeyVoter::EDIT, $translationKey);

        $form = $this->createPutForm(TranslationKeyForm::class, $translationKey);
        $this->formParseRequest($request, $form);

        if ($form->isValid()) {
            return $this->json($translationKey);
        }

        return $this->formError($form);
    }

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
        $this->denyAccessUnlessGranted(TranslationKeyVoter::VIEW, $translationKey);

        return $this->json($translationKey, Response::HTTP_OK, [], [
            TranslationKeyNormalizer::DETAILS,
        ]);
    }
}