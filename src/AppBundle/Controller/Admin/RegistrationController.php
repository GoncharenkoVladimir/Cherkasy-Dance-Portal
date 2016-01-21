<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\Registration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class RegistrationController extends Controller
{
    /**
     * @Route("/registration", name="registration_page")
     * @Template()
     * @return array
     */
    public function registrationAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(Registration::class, $user);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($request->getMethod() == Request::METHOD_POST){
            if ($form->isValid()) {
                $encoder = $this->get('security.encoder_factory')->getEncoder($user);
                $user->setPassword($encoder->encodePassword( $user->getPlainPassword(), $user->getSalt()));

                $em->persist($user);
                $em->flush();
                return $this->loginUser($user);
            }
        }

        return ['form_registration' => $form->createView()];
    }

    /**
     * Used after reset and register to login and redirect to home page
     *
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function loginUser(User $user)
    {
        //The doc same 'home' is the provider key, but actually its the firewall key
        $token = new UsernamePasswordToken($user, null, 'home', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_home', serialize($token));

        return $this->redirect($this->generateUrl('homepage'));
    }
}
