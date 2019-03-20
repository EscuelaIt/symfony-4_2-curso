<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/post/new/{title}/{text}", name="new_post")
     * @param string $title
     * @param string $text
     */
    public function newPost( string $title, string $text )
    {
        $post = new Post();

        $post
            ->setTitle( $title )
            ->setText( $text )
            ;

        $em = $this->getDoctrine()->getManager();
        $em->persist( $post );
        $em->flush();

        return new Response('Nuevo post creado, id: '.$post->getId());
    }

    /**
     * @Route("/post/show/{postId}", name="show_post")
     */

    public function showPost( int $postId )
    {
        $em = $this->getDoctrine()->getManager();
        if ( $post = $em->getRepository( Post::class )->find( $postId ) ) {

            return $this->render('post/show.html.twig', ['post' => $post ]);
        } else {

            throw $this->createNotFoundException( 'El post '.$postId.' no existe!' );
        }
    }

    /**
     * @Route("/post/delete/{postId}", name="delete_post")
     */

    public function deletePost( int $postId )
    {
        $em = $this->getDoctrine()->getManager();
        if ( $post = $em->getRepository( Post::class )->find( $postId ) ) {
            $em->remove( $post );
            $em->flush();

            return $this->redirect( $this->generateUrl('post' ) );
        } else {

            throw $this->createNotFoundException( 'El post '.$postId.' no existe!' );
        }
    }

    /**
     * @Route("/post/categorize/{postId}/{categoryName}", name="categorize_post")
     * @param int $postId
     * @param string $categoryName
     */
    public function categorize( int $postId, string $categoryName )
    {
        $em = $this->getDoctrine()->getManager();

        if ( !( $post = $em->getRepository(Post::class )->find( $postId ) ) ) {

            throw new $this->createNotFoundException();
        }

        if ( !( $category = $em->getRepository( PostCategory::class )->findBy( [ 'name' => $categoryName ] ) ) ) {
            $category = new PostCategory();
            $category->setName($categoryName );
            $em->persist( $category );
        }

        $post->setCategory( $category );
        $em->persist( $post );

        $em->flush();

        return $this->redirect( $this->generateUrl( 'post' ) );
    }
}