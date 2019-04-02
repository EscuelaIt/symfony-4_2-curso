<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 4/2/19
 * Time: 10:11 AM
 */

namespace App\Tests\Service;

use App\Service\MyService;
use PHPUnit\Framework\TestCase;

class MyServiceTest extends TestCase
{
    public function testServeWillReturnServed()
    {
        $sut = new MyService();

        $this->assertEquals( 'Served!', $sut->serve() );
    }
}
