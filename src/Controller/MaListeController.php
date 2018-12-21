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
    public function index(ArticlesRepository $articlesRepository, UserRepository $userRepository)
    {
        $user = $this->getUser();
        $authors = $userRepository->findAllWriter();
        if ($user == null){
            $articles= $articlesRepository->findAll();

        }else{
            $id = $user->getId();
            $articles = $articlesRepository->findByUserConnect($id);
        };

        return $this->render('ma_liste/index.html.twig', [
            'articles'=>$articles,
            'authors'=>$authors
        ]);
    }
}
