<?php

namespace App\Controller\Api;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users", name="user_")
 */
class UserController extends Controller
{
    /**
     * @Route("/me", name="me")
     */
    public function me()
    {
        $user = $this->getUser();

        return $this->json($user);
    }
}