<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/homepage', name: 'app_homepage')]
    public function index(): Response
    {
        return new Response(
            '<html><body><h1>Welcome to the Diet Calculator!</h1></body></html>'
        );
    }
}
