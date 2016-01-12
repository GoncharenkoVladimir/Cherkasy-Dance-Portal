<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Comment;

class DeleteCommentController extends Controller
{
    /**
     * @Route("/delete-comment/{id}", name="delete-comment")
     * @param $id
     * @return array
     */
    public function deleteCommentAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Comment');
        $comments = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($comments);
        $em->flush();
        return $this->redirect($this->generateUrl('admin-comments', array('comments' => $comments)));
    }
}
