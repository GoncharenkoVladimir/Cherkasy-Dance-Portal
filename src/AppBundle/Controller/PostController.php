<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use AppBundle\Form\AddComment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;

class PostController extends Controller
{
    /**
     * @Route("/{_locale}/post/{slug}", name="post_view", defaults={"tag" = 0, "_locale" = "en"}, options={"expose"=true})
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

        $rating = $post->getRating();
        $locale = $request->getLocale();

        $em = $this->getDoctrine()->getManager();
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $commentAdd = new Comment();
        $commentAdd->setAuthor($user);
        $commentAdd->setStatus('published');

        $form = $this->createForm(AddComment::class, $commentAdd);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST){
            if ($form->isValid()) {
                $commentAdd->setPost($post);
                $commentAdd->getPost()->calcRating($commentAdd);
                $em->persist($commentAdd);
                $em->flush();
                return $this->redirect($this->generateUrl('post_view', array('slug' => $post->getSlug(), 'rating' => $rating)));
            }
        }
        $repo = $this->getDoctrine()->getRepository('AppBundle:Post');
        $lastNews = $repo->lastNews($repo);

        return [
            'post' => $post,
            'comments' => $comments,
            'form_comment' => $form->createView(),
            'tags' => $tags,
            'last_news' => $lastNews,
            'rating' => $rating,
            'locale' => $locale
        ];
    }
}
