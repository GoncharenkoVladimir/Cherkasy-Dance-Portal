<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminPostsController extends Controller
{
    /**
     * @Route("/admin-posts", name="admin-posts")
     * @Template()
     */
    public function adminPostsAction()
    {
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
        return ['posts' => $post];
    }
}
