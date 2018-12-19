<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WriterController extends AbstractController
{
    /**
     * @Route("/writer", name="writer")
     */
    public function index()
    {
        return $this->render('writer/index.html.twig', [
            'controller_name' => 'WriterController',
        ]);
    }
}
