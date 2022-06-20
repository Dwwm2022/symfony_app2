<?php

namespace App\Controller;

use App\Entity\Post;
use DateTimeImmutable;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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
        $post->setReference("52356totot30")
             ->setTitle("Election législative")
             ->setContent("survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.")
             ->setAuthor("Anoine")
             ->setPublishedAt(new \DateTimeImmutable())
             ->setImage("election.jpg");
        $manager->persist($post);
        $manager->flush();
        $this->addFlash('success', "Article N°: ".$post->getId()." est créé");
        return $this->redirectToRoute('list_posts', ['id'=>$post->getId()]);
    }

    #[Route('/list', name:"list_posts")]
    public function getPosts(ManagerRegistry $doctrine, Request $request){
        $search = $request->request->get('search');
        //dd($search);
        $repo = $doctrine->getRepository(Post::class);
        $tab_posts = ($search) ? $repo->findSearch($search) : $repo->findBy([],['id'=>'DESC']);
        //$tab_posts = $repo->findAll();
        //dd($tab_posts);
        return $this->render('post/list.html.twig', ['posts'=> $tab_posts]);
    }

    #[Route('/delete/{id}', name:"delete_post")]
    public function deletePost(ManagerRegistry $doctrine, $id){
        $repo = $doctrine->getRepository(Post::class);
        $post = $repo->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($post);
        $manager->flush();
        $this->addFlash('success','L\'article '.$post->getTitle().' a été supprimé');
        return $this->redirectToRoute('list_posts');
    }

    #[Route('/update/{id}', name:"update_post")]
    public function updatePost(PostRepository $repo, $id, ManagerRegistry $doctrine){
        $post = $repo->find($id);
        $post->setTitle('Nième sanction')
            ->setAuthor('Nabil');
        $manager = $doctrine->getManager();
        $manager->flush();
        $this->addFlash('success','L\'article '.$post->getTitle().' a été modifié');
        return $this->redirectToRoute('list_posts');
    }

    #[Route('/show/{id}', name:'show_post')]
    public function showPost(Post $post){
        return $this->render('post/show.html.twig', ['post'=>$post]);
    }
}
