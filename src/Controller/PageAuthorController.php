<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageAuthorController extends AbstractController
{
    /**
     * @Route("/authors", name="index_author")
     */
    public function index(UserRepository $userRepository)
    {
        $authors = $userRepository->findAllWriter();
        return $this->render('page_author/index.html.twig', ['authors'=>$authors]);;
    }
    /**
     * @Route("/{slug}/author", name="page_author")
     */
    public function show(User $author)
    {
        $articles = $this->getDoctrine()->getRepository(Articles::class)->findBy(['author'=>$author],['date'=>'DESC']);
        $count = count($articles);
        dump($count);
        return $this->render('page_author/show.html.twig', ['author'=>$author,
            'count'=>$count]);
    }
}
