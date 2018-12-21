<?php

namespace App\Controller;

use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DebatController extends AbstractController
{
    /**
     * @Route("/debat/{slug}", name="debat")
     */
    public function index(Articles $article) : Response
    {
        return $this->render('debat/index.html.twig', [
            'article' => $article
        ]);
    }
}
