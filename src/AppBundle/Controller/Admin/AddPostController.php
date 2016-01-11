<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\AddPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;

class AddPostController extends Controller
{
    /**
     * @Route("/add-post", name="add-post")
     * @Template()
     */
    public function addPostAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find(84);
        $post = new Post($user);
        $form = $this->createForm(AddPost::class, $post);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST){
            if ($form->isValid()) {
                $em->persist($post);
                $em->flush();
            }
        }
        return ['form' => $form->createView()];
    }
}
