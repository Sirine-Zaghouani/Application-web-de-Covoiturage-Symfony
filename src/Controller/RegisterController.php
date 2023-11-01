<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{


    /**
     * @Route ("/inscription",name="register")
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $User = new User();
        $form=$this->createForm(RegisterType::class,$User);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user=$form->getData();
            $password=$encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            $doctrine=$this->getDoctrine()->getManager();
            $doctrine->persist($user);
            $doctrine->flush();
            return $this->redirectToRoute('app_login');
        }
        return$this->render('register/index.html.twig',[
            'form'=>$form->createView()
        ]);
        return $this->redirectToRoute('home');
    }
}
