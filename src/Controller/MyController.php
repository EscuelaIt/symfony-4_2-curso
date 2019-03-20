<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyController extends AbstractController
{
    /**
     * @Route("/my/index", name="my")
     */
    public function index()
    {
        return $this->render('my/index.html.twig', [
            'controller_name' => 'MyController',
        ]);
    }

    /**
     * @Route("/hello/world", name="hello_world")
     * @return Response
     */
    public function helloWorld()
    {
        return new Response('
            <html>
                <body>
                    <p>Hola mundo!</p>
                    <p><a href="'.$this->generateUrl('my').'">Soy un link!</a></p>
                </body>
            </html>');
    }

    /**
     * @Route("/hello/{name}", name="hello_user")
     * @param string $name
     * @return Response
     */
    public function helloUser( string $name )
    {
        return new Response('<html><body><p><a href="'.$this->generateUrl('hello_user', [ 'name' => $name ] ).'">Click aqui</a></p></body></html>');
    }
}
