<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 4/1/19
 * Time: 8:25 PM
 */

namespace App\Tests\Entity;

use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{

    public function testSetTitleWillNotAcceptTituloAsValue()
    {
        $this->expectException( \Exception::class );
        $sut = new Post();
        $forbiddenTitle = 'Titulo';

        $sut->setTitle($forbiddenTitle);
    }

    public function testSetTitleWillStoreTitle()
    {
        $sut = new Post();
        $sut->setTitle('Un post');

        $this->assertEquals( 'Un post', $sut->getTitle() );
    }
}
