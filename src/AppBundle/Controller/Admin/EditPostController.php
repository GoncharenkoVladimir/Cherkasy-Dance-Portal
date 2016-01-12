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
    public function editPostAction(Request $request, $id)
    {
        $post = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->find($id);

        $form = $this->createForm(AddPost::class, $post);

        $form->handleRequest($request);
        if($request->getMethod() == Request::METHOD_POST) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
            }
        }

        return [
            'post' => $post,
            'form' => $form->createView()
        ];
    }
}
