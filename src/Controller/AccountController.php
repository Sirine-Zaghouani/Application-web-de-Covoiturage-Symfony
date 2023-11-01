<?php

namespace App\Controller;

use App\Form\ChangeInfosPersonType;
use App\Form\ChangeInfosType;
use App\Form\ChangePasswordType;
use App\Form\DeleteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{

    #[Route('/compte', name: 'account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    #[Route('/Mon_profil', name: 'mon_profil')]
    public function InfosPers(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $user=$this->getUser();
        $form1=$this->createForm(ChangeInfosType::class,$user);

        $form1->handleRequest($request);

        if($form1->isSubmitted()&& $form1->isValid()){
            $old_pwd=$form1->get('old_password')->getData();
            if($encoder->isPasswordValid($user,$old_pwd)){

                $new_nom=$form1->get('nom')->getData();
                $user->setNom($new_nom);

                $new_prenom=$form1->get('prenom')->getData();
                $user->setPrenom($new_prenom);

                $new_adresse=$form1->get('adresse')->getData();
                $user->setAdresse($new_prenom);

                $new_civilite=$form1->get('civilite')->getData();
                $user->setCivilite($new_civilite);

                $new_profession=$form1->get('profession')->getData();
                $user->setProfession($new_profession);

                $new_profession=$form1->get('profession')->getData();
                $user->setProfession($new_profession);

                $new_telephone=$form1->get('telephone')->getData();
                $user->setTelephone($new_telephone);

                $new_naissance=$form1->get('naissance')->getData();
                $user->setNaissance($new_naissance);

                $doctrine=$this->getDoctrine()->getManager();
                $doctrine->persist($user);
                $doctrine->flush();


            }

        }

        $form=$this->createForm(ChangePasswordType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $old_pwd=$form->get('old_password')->getData();
            if($encoder->isPasswordValid($user,$old_pwd)){
                $new_pwd=$form->get('new_password')->getData();
                $password=$encoder->encodePassword($user,$new_pwd);
                $user->setPassword($password);
                $doctrine=$this->getDoctrine()->getManager();
                $doctrine->persist($user);
                $doctrine->flush();

            }

        }


        $form2=$this->createForm(DeleteType::class);

        $form2->handleRequest($request);


        if($form2->isSubmitted()&& $form2->isValid()){
            $old_pwd=$form2->get('old_password')->getData();
            if($encoder->isPasswordValid($user,$old_pwd)) {
                $doctrine=$this->getDoctrine()->getManager();
                $doctrine->remove($user);
                $doctrine->flush();
                return $this->redirectToRoute('home');
            }

        }




        return $this->render('account/profil.html.twig',[
            'form_infos'=>$form1->createView(),
            'form_mot_passe'=>$form->createView(),
            'delete_account'=>$form2->createView()
        ]);
    }

}
