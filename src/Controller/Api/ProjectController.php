<?php

namespace App\Controller\Api;

use App\Entity\Project;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/projects", name="projects_")
 */
class ProjectController extends Controller
{
    /**
     * @Route("", name="index")
     */
    public function index()
    {
        $projects = $this->getDoctrine()->getRepository(Project::class)
            ->findUserProjects($this->getUser());

        return $this->json($projects);
    }
}