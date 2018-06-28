<?php

namespace App\Controller\Api;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    protected function createPostForm(string $type, $data = null, array $options = []): FormInterface
    {
        $options['method'] = 'POST';

        return $this->createForm($type, $data, $options);
    }

    protected function createPutForm(string $type, $data = null, array $options = []): FormInterface
    {
        $options['method'] = 'PUT';

        return $this->createForm($type, $data, $options);
    }

    protected function createPatchForm(string $type, $data = null, array $options = []): FormInterface
    {
        $options['method'] = 'PATCH';

        return $this->createForm($type, $data, $options);
    }

    protected function formParseRequest(Request $request, FormInterface $form)
    {
        $form->submit(json_decode($request->getContent(), true));
    }

    protected function formError(FormInterface $form)
    {
        return $this->json($form, Response::HTTP_BAD_REQUEST);
    }
}