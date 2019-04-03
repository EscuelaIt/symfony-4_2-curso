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

        $this->assertTrue( $client->getResponse()->isRedirect('http://localhost/login') );
    }
}
