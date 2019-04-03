<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 4/2/19
 * Time: 8:50 PM
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MyControllerTest extends WebTestCase
{
    public function testHelloUserWillPrintTheNameReceivedViaUrl()
    {
        $client = WebTestCase::createClient();

        $client->request('GET', '/hello/mauro');
        $crawler = $client->getCrawler();
        $paragraph = $crawler
            ->filter('p')
            ->first()
            ;
        $this->assertRegExp( '/mauro/', $paragraph->html() );
    }
}
