<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\User;
use App\Repository\ArticlesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MaListeController extends AbstractController
{
    /**
     * @Route("/maliste", name="ma_liste")
     */
    public function index(ArticlesRepository $articlesRepository)
    {
        $user = $this->getUser();
        $id = $user->getId();
        if ($user == null){
            $articles= $articlesRepository->findAll();
        }else{
            $articles = $articlesRepository->findByUserConnect($id);
        };
        dump($articles);


        return $this->render('ma_liste/index.html.twig', [
            'articles'=>$articles,
        ]);
    }
}
