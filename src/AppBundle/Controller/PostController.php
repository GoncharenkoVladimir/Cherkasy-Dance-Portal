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
     * @Route("/post/{slug}", name="post_view")
     * @param string $slug
     * @Template()
     * @return array
     */
    public function postAction($slug, Request$request )
    {
        /**
         * @var Post $post
         */
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->findOneBySlug($slug);
        $tags = $this->getDoctrine()->getRepository('AppBundle:Tag')->findAll();
        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->findByPost($post->getId());

        $rating = 0;
        $k = 0;

        foreach($comments as $value){
            /**
             * @var Comment $value
             */
            $reg = $value->getRating();
            if( $reg != 0){
                $k++;
            }
            $rating = ($rating + $reg);
        }

        if($k != 0){
            $rating = $rating/$k;
        }

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

                return $this->redirect($this->generateUrl('post_view', array('slug' => $post->getSlug(), 'rating' => $rating)));
            }
        }
        $repo = $this->getDoctrine()->getRepository('AppBundle:Post');
        $lastNews = $repo->lastNews($repo);

        return ['post' => $post, 'comments' => $comments, 'form_comment' => $form->createView(), 'tags' => $tags, 'last_news' => $lastNews, 'rating' => $rating];
    }
}
