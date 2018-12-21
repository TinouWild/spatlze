<?php

namespace App\Controller;

use App\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TendancesController extends AbstractController
{
    /**
     * @Route("/tendances", name="tendances")
     */
    public function index()
    {
        return $this->render('tendances/index.html.twig');
    }
}
