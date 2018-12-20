<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Theme;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use App\Repository\UserRepository;
use App\Services\CountDown;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/nouveautes", name="articles_nouveautes", methods={"GET"})
     */
    public function index(ArticlesRepository $articlesRepository, UserRepository $userRepository): Response
    {
        $article = $articlesRepository->findByMostRecentDate(new \DateTime());
        $articles = $articlesRepository->findAll();
        $authors = $userRepository->findLastSixRecentWriter();
        dump($authors);
        return $this->render('articles/nouveautes.html.twig', ['articles' => $articles,
            'recentarticle' =>$article,
            'authors'=> $authors]);
    }

    /**
     * @Route("/new", name="articles_new", methods={"GET","POST"})
     */
    public function new(Request $request, ObjectManager $manager): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setAuthor($this->getUser());

            foreach ($article->getTheme() as $theme) {
                $theme->getArticles($article);
                $manager->persist($theme);
            }

            foreach ($article->getTag() as $tag) {
                $tag->getArticles($article);
                $manager->persist($tag);
            }
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('articles_nouveautes');
        }

        return $this->render('articles/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="articles_show", methods={"GET"})
     */
    public function show(Articles $article, CountDown $countDown): Response
    {
        $countDown->DebatCountDonw($article->getDate());
        return $this->render('articles/show.html.twig', ['article' => $article,
            'countDown' => $countDown]);
    }

    /**
     * @Route("/{id}/edit", name="articles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Articles $article): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('articles_index', ['id' => $article->getId()]);
        }

        return $this->render('articles/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="articles_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Articles $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('articles_index');
    }
}
