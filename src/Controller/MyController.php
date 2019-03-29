<?php

namespace App\Controller;

use App\Service\MyService;
use App\Service\Notifier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Psr\Log\LoggerInterface;

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
     * @IsGranted("ROLE_USER")
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

    /**
     * @Route(path="/test/i18n/{name}", name="test_i18n")
     * @param Request $request
     * @return Response
     */
    public function testI18n( TranslatorInterface $translator, string $name )
    {
        $html = "
<html>
   <body>".$translator->trans('create')." $name</body>
</html>";

        return new Response( $html );
    }

    /**
     * @Route(path="/email/send/{to}/{subject}", name="send_email")
     */
    public function sendEmail( Notifier $notifier, string $to, string $subject ): Response
    {
        $notifier->notify( $this->getParameter('adminEmail'), $to, $subject );

        return $this->render('my/email_sent.html.twig');
    }

    /**
     * @param LoggerInterface $logger
     * @param string $message
     * @return Response
     * @Route(name="log_message", path="/log/{message}")
     */
    public function logMessage(LoggerInterface $logger, string $message): Response
    {
        $logger->alert($message);

        return new Response('<html><body><p>Message logged!</p></body></html>');
    }

    /**
     * @Route(name="log_exception", path="/log_exception")
     */
    public function logException()
    {
        throw new \Exception('Excepcion logeable');
    }

    /**
     * @Route(path="/service/test", name="service_test")
     * @param MyService $myService
     * @return Response
     */
    public function testService( MyService $myService )
    {
        return new Response( $myService->serve() );
    }
}
