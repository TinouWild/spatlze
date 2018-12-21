<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MaListeController extends AbstractController
{
    /**
     * @Route("/ma/liste", name="ma_liste")
     */
    public function index()
    {

        return $this->render('ma_liste/index.html.twig', [
            'article'=>$article,
        ]);
    }
}
