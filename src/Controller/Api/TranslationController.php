<?php

namespace App\Controller\Api;

use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Form\TranslationForm;
use App\Security\TranslationVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @SWG\Tag(name="Translation Values")
 *
 * @Route("/translation", name="translation_")
 */
class TranslationController extends Controller
{
    /**
     * Get full details of a single translation
     *
     * @SWG\Response(response=200, description="")
     *
     * @Method("GET")
     * @Route("/{id}", name="details")
     */
    public function details(Translation $translation)
    {
        $this->denyAccessUnlessGranted(TranslationVoter::VIEW, $translation);

        return $this->json($translation);
    }

    /**
     * Create or update translation
     *
     * @SWG\Response(response=200, description="")
     *
     * @Method("POST")
     * @Route("", name="create")
     */
    public function create(Request $request)
    {
        $translation = $this->findOrCreateTranslation($request);

        $form = $this->createPostForm(TranslationForm::class, $translation);
        $this->formParseRequest($request, $form);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $status = Response::HTTP_OK;

            if (!$translation->getId()) {
                $status = Response::HTTP_CREATED;
                $em->persist($translation);
            }

            $em->flush();

            return $this->json($translation, $status);
        }

        return $this->json($form, 400);
    }

    private function findOrCreateTranslation(Request $request)
    {
        $json = json_decode($request->getContent(), true);

        if (isset($json['translationKey']) && isset($json['locale'])) {
            $key = $this->getDoctrine()->getRepository(TranslationKey::class)
                ->find($json['translationKey']);

            if (!$key) {
                return null;
            }

            $translation = $this->getDoctrine()->getRepository(Translation::class)
                ->getByKeyAndLocale($key, $json['locale']);

            if ($translation) {
                return $translation;
            }
        }

        return new Translation();
    }
}