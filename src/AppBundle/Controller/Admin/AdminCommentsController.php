<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminCommentsController extends Controller
{
    /**
     * @Route("/admin-comments", name="admin-comments")
     * @Template()
     */
    public function adminCommentsAction()
    {
        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->findAll();
        return ['comments' => $comments];
    }
}
