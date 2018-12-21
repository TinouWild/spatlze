<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\PostLike;
use App\Repository\ArticlesRepository;
use App\Repository\PostLikeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Articles $posts){
        return $this->render('tendances/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/post/{id}/like", name="post_like")
     * @param Articles $post
     * @param ObjectManager $manager
     * @param PostLikeRepository $likerepo
     * @return Response
     */
    public function like(Articles $post, ObjectManager $manager, PostLikeRepository $likerepo) : Response
    {
        $user = $this->getUser();
        if (!$user) return $this->json([
            'code' => 403,
            'message' => 'Il faut être conecté'
        ], 403);

        if ($post->isLikedByUser($user)) {
            $like = $likerepo->findOneBy([
                'post' => $post,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $likerepo->count(['post' => $post])
            ],200);
        }

        $like = new PostLike();
        $like->setPost($post)
            ->setUser($user);
        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes' => $likerepo->count(['post' => $post])
        ], 200);
    }
}

