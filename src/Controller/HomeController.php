<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class HomeController extends AbstractController
{
    private $data;
    public function __construct()
    {
        $this->data =  [
            ["id" => 1, "name" => "Dupond", "lastname" => "Roger", "age" => 22, "image" => "roger.jpg"],
            ["id" => 2, "name" => "Durand", "lastname" => "Thomas", "age" => 52, "image" => "thomas.jpeg"],
        ];
    }

    #[Route('/log', name: 'app_log')]
    public function indexLogger(LoggerInterface $logger)
    {
        $logger->info('I just got the logger');
        $logger->error('Erreur grave');

        $logger->critical('Erreur critique', [
            // include extra "context" info in your logs
            'cause' => 'Erreur critique',
        ]);

        return new Response("<html><head></head><body>test</body></html>");
    }
    
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

        return $this->render('home/data.html.twig', [
            'personnes' => $this->data,
        ]);
    }

    /**
     * @Route("/admin/person/{id}", name="person_item")
     */
    public function getItem(int $id)
    {
        foreach ($this->data as $person) {
            if ($person['id'] == $id) {
                return $this->render('home/item_person.html.twig', ['person_data' => $person]);
            }
        }
    }
}
