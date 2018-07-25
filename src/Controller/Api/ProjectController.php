<?php

namespace App\Controller\Api;

use App\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @SWG\Tag(name="Projects")
 * @Route("/projects", name="projects_")
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
}