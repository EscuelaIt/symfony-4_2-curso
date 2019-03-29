<?php
/**
 * Created by PhpStorm.
 * User: mchoj
 * Date: 27/3/2019
 * Time: 15:22
 */

namespace App\Service;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Twig\Environment;

class Notifier
{
    private $mailer;
    private $logger;
    private $twigEnvironment;
    private $adminEmail;

    /**
     * Notifier constructor.
     * @param \Swift_Mailer $mailer
     * @param LoggerInterface $logger
     * @param Environment $twigEnvironment
     * @param string $adminEmail
     */
    public function __construct( \Swift_Mailer $mailer, LoggerInterface $logger, Environment $twigEnvironment, string $adminEmail )
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->twigEnvironment = $twigEnvironment;
        $this->adminEmail = $adminEmail;
    }

    /**
     * @param string $to
     * @param string $subject
     */
    public function notify( string $fromEmail, string $to, string $subject )
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom($fromEmail, $this->adminEmail)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody(
                $this->twigEnvironment->render('my/email_body.html.twig', [ 'texto' => 'Un texto']),
                'text/html'
            );

        $this->mailer->send($message);
        $this->logger->info('Se ha enviado un correo a "'.$to.'" con subject "'.$subject.'" desde "'.$fromEmail.'". El mail del admin es '.$this->adminEmail );
    }
}