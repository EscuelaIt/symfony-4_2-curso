<?php

namespace App\Controller;

use App\Entity\PostCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostCategoryController extends AbstractController
{
    /**
     * @Route("/post_category", name="post_category")
     */
    public function index()
    {
        $categories = $this->getDoctrine()->getRepository( PostCategory::class )
            ->findNewlyCreated();

        return $this->render('post_category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

}
