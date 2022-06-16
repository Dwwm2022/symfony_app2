<?php

namespace App\Controller;

use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/post2', name: 'app_post')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
     * @Route("/post", name="create_post")
     */
    public function createPost(ManagerRegistry $doctrine){
        $manager = $doctrine->getManager();

        $post = new Post();
        $post->setReference("52356totot27")
             ->setTitle("Présidence")
             ->setContent("survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.")
             ->setAuthor("Antonin")
             ->setPublishedAt(new DateTimeImmutable())
             ->setImage("election.jpg");

        $manager->persist($post);
        $manager->flush();
        return new Response('Article inséré');
    }

    #[Route('/list', name:"list_posts")]
    public function getPosts(ManagerRegistry $doctrine){
        $manager = $doctrine->getRepository(Post::class);
        $tab_posts = $manager->findAll();
        //dd($tab_posts);
        return $this->render('post/list.html.twig', ['posts'=> $tab_posts]);
    }
}
