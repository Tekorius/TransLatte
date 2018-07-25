<?php

namespace App\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @SWG\Tag(name="User")
 * @Route("/users", name="user_")
 */
class UserController extends Controller
{
    /**
     * Get current user's info
     *
     * @SWG\Response(response=200, description="")
     *
     * @Method("GET")
     * @Route("/me", name="me")
     */
    public function me()
    {
        $user = $this->getUser();

        return $this->json($user);
    }
}