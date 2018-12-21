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

    /**
     * @Route("/debat/{slug}/view_the_debat", name="debat_view")
     */
    public function viewDebat(Articles $article) : Response
    {
        return $this->render('debat/view.html.twig', [
            'article' => $article
        ]);
    }
}
