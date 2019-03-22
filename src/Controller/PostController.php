<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostCategory;
use App\Form\PostType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class PostController
 * @package App\Controller
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post")
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
     * @Route("/new/{title}/{text}", name="new_post")
     * @param string $title
     * @param string $text
     */
    public function new( string $title, string $text, TranslatorInterface $translator )
    {
        $post = new Post();

        $post
            ->setTitle( $title )
            ->setText( $text )
            ;

        $em = $this->getDoctrine()->getManager();
        $em->persist( $post );
        $em->flush();

        return new Response( $translator->trans('post.new.success', [ '$postId' => $post->getId() ] ) );
    }

    /**
     * @Route("/show/{postId}", name="show_post")
     */

    public function show( int $postId, TranslatorInterface $translator )
    {
        $em = $this->getDoctrine()->getManager();
        if ( $post = $em->getRepository( Post::class )->find( $postId ) ) {

            return $this->render('post/show.html.twig', ['post' => $post ]);
        } else {

            throw $this->createNotFoundException( $translator->trans( 'post.not_found', [ '$postId' => $postId ] ) );
        }
    }

    /**
     * @Route("/delete/{postId}", name="delete_post")
     */

    public function delete( int $postId, TranslatorInterface $translator )
    {
        $em = $this->getDoctrine()->getManager();
        if ( $post = $em->getRepository( Post::class )->find( $postId ) ) {
            $em->remove( $post );
            $em->flush();

            return $this->redirect( $this->generateUrl('post' ) );
        } else {

            throw $this->createNotFoundException( $translator->trans( 'post.not_found', ['$postId' => $postId ] ) );
        }
    }

    /**
     * @Route("/categorize/{postId}/{categoryName}", name="categorize_post")
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

    /**
     * @Route("/new", name="interactively_create_post")
     */
    public function interactivelyCreate( Request $request )
    {
        $post = new Post();
        $form = $this->createForm( PostType::class, $post )
            ->add( 'Enviar', SubmitType::class )
        ;
        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $objectManager = $this->getDoctrine()->getManager();
            $objectManager->persist( $post );
            $objectManager->flush();

            return $this->redirectToRoute('post');
        }

        return $this->render('post/form.html.twig', [ 'form' => $form->createView() ] );
    }

    /**
     * @Route("/update/{postId}", name="update_post")
     * @param Request $request
     */
    public function update(Request $request, int $postId)
    {
        if ( ( $post = $this->getDoctrine()->getRepository(Post::class )->find( $postId ) ) == null ) {

            throw $this->createNotFoundException();
        }

        $form = $this->createForm( PostType::class, $post )
            ->add( 'Enviar', SubmitType::class )
        ;
        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $objectManager = $this->getDoctrine()->getManager();
            $objectManager->persist( $post );
            $objectManager->flush();

            return $this->redirectToRoute('show_post', [ 'postId' => $postId ] );
        }

        return $this->render('post/form.html.twig', [ 'form' => $form->createView() ] );
    }
}