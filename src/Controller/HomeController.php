<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/person', name: 'app_person')]
    public function getData(): Response
    {
        $data = [
            ["id"=>1, "name"=>"Dupond", "lastname"=>"Roger","age"=>22, "image"=>"dupond.jpg"],
            ["id"=>2, "name"=>"Durand", "lastname"=>"Simon","age"=>52, "image"=>"simon.jpg"],
        ];
        return $this->render('home/data.html.twig', [
            'personnes' => $data,
        ]);
    }
}
