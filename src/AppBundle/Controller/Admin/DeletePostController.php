<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\AddPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;

class DeletePostController extends Controller
{
    /**
     * @Route("/delete-post/{id}", name="delete-post")
     * @param $id
     * @return array
     */
    public function deletePostAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post');
        $post = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->redirect($this->generateUrl('admin-posts', array('post' => $post)));
    }
}
