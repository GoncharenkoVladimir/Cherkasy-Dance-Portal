<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Post;

class DeleteUserController extends Controller
{
    /**
     * @Route("/delete-user/{id}", name="delete-user")
     * @param $id
     * @return array
     */
    public function deleteUserAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:User');
        $users = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($users);
        $em->flush();
        return $this->redirect($this->generateUrl('admin-users', array('users' => $users)));
    }
}
