<?php

namespace App\Controller\Api;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test", name="test_")
 */
class TestController extends Controller
{
    /**
     * @Route("/", name="index_get")
     * @Method({"GET"})
     */
    public function indexGet()
    {
        return $this->json(['test' => 'yay']);
    }
}