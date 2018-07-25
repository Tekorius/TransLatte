<?php

namespace App\Controller\Api;

use App\Entity\Project;
use App\Entity\Translation;
use App\Entity\TranslationFile;
use App\Entity\TranslationKey;
use App\Security\ProjectVoter;
use App\Serializer\Normalizer\TranslationFileNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @SWG\Tag(name="Projects")
 * @Route("/projects", name="project_")
 */
class ProjectController extends Controller
{
    /**
     * Get projects assigned to the current user
     *
     * @SWG\Response(response=200, description="")
     *
     * @Method("GET")
     * @Route("", name="index")
     */
    public function index()
    {
        $projects = $this->getDoctrine()->getRepository(Project::class)
            ->findUserProjects($this->getUser());

        return $this->json($projects);
    }

    /**
     * Get files that belong to the project
     *
     * @SWG\Response(response=200, description="")
     *
     * @Method("GET")
     * @Route("/{id}/files", name="files")
     */
    public function files(Project $project)
    {
        $this->denyAccessUnlessGranted(ProjectVoter::VIEW, $project);

        $files = $this->getDoctrine()->getRepository(TranslationFile::class)
            ->findByProject($project);

        $this->getDoctrine()->getRepository(TranslationKey::class)
            ->countForFiles($files);

        $this->getDoctrine()->getRepository(Translation::class)
            ->countForFiles($files);

        return $this->json($files, Response::HTTP_OK, [], [
            TranslationFileNormalizer::KEY_COUNTS,
        ]);
    }
}