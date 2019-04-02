<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 4/2/19
 * Time: 10:29 AM
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostControllerTest extends WebTestCase
{

    public function testIndexWillRedirectToLoginIfAnonymous()
    {
        $client = static::createClient();

        $client->request('GET', '/post/');

        $this->assertTrue($client->getResponse()->isRedirect('/login') );
    }

    public function testLoginIsPossible()
    {
        $client = static::createClient();

        $client->request('GET', '/login/');

        $crawler = $client->getCrawler();
        $form = $crawler->selectButton('submit')->form();
        $form->set('username', 'admin');
        $form->set('password', 'admin');

        $crawler = $client->submit( $form );
    }
}
