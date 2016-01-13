<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Form\AddComment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;

class PostController extends Controller
{
    /**
     * @Route("/post/{slug}", name="post")
     * @param string $slug
     * @Template()
     * @return array
     */
    public function postAction($slug, Request$request )
    {
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->findOneBySlug($slug);
        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->findByPost($post->getId());

        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find(84);

        $commentAdd = new Comment();
        $commentAdd->setAuthor($user);
        $commentAdd->setStatus('published');
        $commentAdd->setEmail('test@test.test');
        $commentAdd->setUrl('test.tt.ttt');

        $form = $this->createForm(AddComment::class, $commentAdd);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST){
            if ($form->isValid()) {
                $commentAdd->setPost($post);
                $em->persist($commentAdd);
                $em->flush();

                /**
                 * @var Post $post
                 */
                return $this->redirect($this->generateUrl('post', array('post' => $post)));
            }
        }

        return ['post' => $post, 'comments' => $comments, 'form' => $form->createView()];
    }
}
