<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\AddPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;

class EditPostController extends Controller
{
    /**
     * @Route("/edit-post/{id}", name="edit-post")
     * @Template()
     * @param $id
     * @return array
     */
    public function editPostAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post');
        $post = $repository->find($id);

        return ['posts' => $post];
    }
}
