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
        $arr = ['name' => $name];

        return $this->render('my/hello.html.twig', $arr);//new Response('<html><body><p><a href="'.$this->generateUrl('hello_user', [ 'name' => $name ] ).'">Click aqui</a></p></body></html>');
    }

    /**
     * @Route("/show/table", name="show_table")
     * @return Response
     */
    public function showTable()
    {
        $records = [
            [ 'firstName' => 'mauro', 'lastName' => 'chojrin', 'email' => 'mauro.chojrin@leewayweb.com', 'age' => 41 ],
            [ 'firstName' => 'Juan', 'lastName' => 'Perez', 'email' => 'juanp@gmail.com', 'age' => 17 ],
        ];

        return $this->render( 'my/showTable.html.twig', [
            'records' => $records,
        ]);
    }
}
