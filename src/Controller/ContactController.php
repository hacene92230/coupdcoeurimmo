<?php

namespace App\Controller;

use App\Entity\Contact;

 use App\Entity\User;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new contact();
        $form= $this-> createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
           
            $contact->setSubject(
                $form->get('subject')-> getData()
            );

            $contact->setContent(
                $form->get('content')->getData()
            );

            $entityManager->persist($contact);
            $entityManager->flush();
            
        }
        
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController', 
            'contactForm' => $form -> createView()
            
        ]);
    }
}
