<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use AppBundle\Form\AddComment;
use AppBundle\Form\Login;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use Symfony\Component\Security\Core\Security;

class LoginController extends Controller
{

    /**
     * @Route("/login", name="login_page")
     * @Template
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        $form = $this->createForm(Login::class, [
            'username' => $session->get(Security::LAST_USERNAME)
        ], [
            'action' => $this->generateUrl('login_check')
        ]);

        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                Security::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(Security::AUTHENTICATION_ERROR)) {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            $this->addFlash('danger', $this->get('translator')->trans($error->getMessage()));
        }
        return [
            'form_login' => $form->createView()
        ];
    }


}
