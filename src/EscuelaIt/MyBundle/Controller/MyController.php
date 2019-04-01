<?php

namespace App\EscuelaIt\MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MyController
 * @package App\EscuelaIt\MyBundle\Controller
 * @Route(path="/my_bundle")
 */
class MyController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="my_bundle_index")
     */
    public function index() : Response
    {
        return new Response('<h1>Hola desde MyBundle!</h1>');
    }
}