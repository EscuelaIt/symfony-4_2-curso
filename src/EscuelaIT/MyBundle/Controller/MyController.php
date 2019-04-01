<?php


namespace App\EscuelaIT\MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MyController
 * @package App\EscuelaIT\MyBundle\Controller
 * @Route(path="/escuelait")
 */

class MyController extends AbstractController
{
    /**
     * @return Response
     * @Route(path="/", name="my_bundle_index")
     */
    public function index() : Response
    {
        return new Response('Hola desde MyBundle!');
    }
}