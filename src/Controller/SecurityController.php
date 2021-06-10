<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
    	// get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();

	    // last username entered by the user
	    $lastUsername = $authenticationUtils->getLastUsername();

	    return $this->render('security/login.html.twig', array(
	        'last_username' => $lastUsername,
	        'error'         => $error,
	    ));
    }
	/**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/home", name="home")
     */
    public function redirectAction()
    {
        $authcheker=$this->get('security.authorization_checker');
        if ($authcheker->isGranted('ROLE_ADMIN')) {
 return $this->render('security/admin.html.twig');}
        elseif ($authcheker->isGranted('ROLE_USER')) {
return $this->render('security/user.html.twig');}
else {return $this->render('security/user.html.twig');}

     }
}