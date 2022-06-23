<?php

namespace App\Controller;

use App\Entity\Theme;
use Symfony\Component\Mime\Email;
use App\Repository\PostRepository;
use App\Repository\ThemeRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublicController extends AbstractController
{
    #[Route('/public', name: 'app_public')]
    public function index(): Response
    {
        return $this->render('public/index.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }

    #[Route('/', name: 'app_public_home')]
    public function home(PostRepository $postRepo, ThemeRepository $themeRepo, Request $request): Response
    {
        $search = $request->request->get('search');
        $posts = ($search) ? $postRepo->findSearch($search) : $postRepo->findBy([], ['id' => 'DESC']);

        return $this->render('public/home.html.twig', [
            'posts' => $posts,
            'themes' => $themeRepo->findAll()
        ]);
    }

    #[Route('/theme/{id}/posts', name: 'app_public_theme_posts')]
    public function postsByTheme(Theme $theme): Response
    {
        return $this->render('public/posts_theme.html.twig', [
            'posts' => $theme->getPosts(),
        ]);
    }

    #[Route('/about', name: 'app_public_about')]
    public function about(): Response
    {
        return $this->render('public/about.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }

    #[Route('/contact', name: 'app_public_contact')]
    public function contact(MailerInterface $mailer): Response
    {
       
        return $this->render('public/contact.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }
}
