<?php

namespace App\Controller;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
class ContactController extends AbstractController

{
    /**
     * @Route("/contact", name="contact")
     */
 public function index(Request $request, MailerInterface $mailer): Response    {
     $msg=$request->get('message');
    $contact=new Contact();
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
if($form->isSubmitted()&&$form->isValid())
{
            $name = $form['name']->getData();
           $email = $form['email']->getData();
           $message = $form['message']->getData();
           $contact->setName($name);
           $contact->setEmail($email);  
           $contact->setMessage($message); 
    $sn = $this->getDoctrine()->getManager();      
           $sn -> persist($contact);
           $sn -> flush();

           $email = (new Email())
            ->from($email)
            ->to('symfprojet@gmail.com')
            ->subject('Time for Symfony Mailer!')
            ->text($message)
            ->html($message);

        $mailer->send($email);

return $this->redirectToRoute('contact');

}
        return $this->render('contact/index.html.twig', [
           'form' => $form->createView()
        ]);
    }
}