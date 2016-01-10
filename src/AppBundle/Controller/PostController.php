<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Post;

class PostController extends Controller
{
    /**
     * @Route("/post/{slug}", name="post")
     * @param string $slug
     * @Template()
     * @return array
     */
    public function postAction($slug)
    {
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->findOneBySlug($slug);
        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->findByPost($post->getId());

        return ['post' => $post, 'comments' => $comments];
    }
}
