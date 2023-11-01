<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Reservation;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AddReservationController extends AbstractController
{
    /**
     * @Route ("/addreservation/{id}",name="add_reservation")
     * @param Request $request
     * @param $id
     * @param $user
     * @param $annonce
     * @return Response
     */

    public function addReservation(Request $request, $id): Response
    {
        $reservation =new Reservation();
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository(Annonce::class)->find($id);
        $reservation->setAnnonce($annonce);
        $user1 = $annonce->getUser();
        $reservation->setUser1($user1);
        $user=$this->getUser();
        $reservation->setUser($user);
        $reservation->setEtat(0);
        $reservation->setDateRes(new \DateTime());
        if($annonce!==null and $user!==null){
            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('MyReservation');
        }else{
            throw new NotFoundHttpException("la demande d'id".$id."n'existe pas");
        }
        return $this->redirectToRoute('MyReservation');

    }
    /**
     * @Route ("/AcceptReservation/{id}",name="AcceptReservation")
     * @param Request $request
     * @param $id
     * @param $user
     * @param $reservation
     * @return Response
     */
    public function AcceptReservation($id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(Reservation::class)->find($id);
        if($reservation!==null) {
            $reservation->setEtat(1);
            $em->persist($reservation);
            $em->flush();
        }
            return $this->redirectToRoute('ARReservation');
    }
    /**
     * @Route ("/RefuseReservation/{id}",name="RefuseReservation")
     * @param Request $request
     * @param $id
     * @param $user
     * @param $reservation
     * @return Response
     */
    public function RefuseReservation( $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(Reservation::class)->find($id);
        $reservation->setEtat(2);
        if($reservation!==null){
            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('AllPosts');
        }else{
            throw new NotFoundHttpException("la reservation d'id".$id."n'existe pas");
        }
        return $this->redirectToRoute('AllPost');
    }
    #[Route('/MyReservation', name: 'MyReservation')]
    public function MesReservation(): Response
    {
        $user= ($this->getUser());
        $em=$this->getDoctrine()->getManager();
        $MyReservation=$em->getRepository("App\Entity\Reservation")->findBy(array('user'=>$user));
        return $this->render('add_reservation/index.html.twig',[
            "MesReservation"=>$MyReservation]);
    }
    #[Route('/deleteReservation/{id}', name: 'ReservationDelete')]
    public function ReservationDelete($id): Response
    {
        $em=$this->getDoctrine()->getManager();
        $Reservation=$em->getRepository("App\Entity\Reservation")->find($id);
        if($Reservation!==null){
            $em->remove($Reservation);
            $em->flush();
        }else{
            throw new NotFoundHttpException("l'annonce d'id".$id."n'existe pas");
        }
        return $this->redirectToRoute('MyReservation');

    }
    #[Route('/ARReservation', name: 'ARReservation')]
    public function ARReservation(): Response
    {
        $user= ($this->getUser());
        $em=$this->getDoctrine()->getManager();
        $ListReservation=$em->getRepository("App\Entity\Reservation")->findBy(array('User1' =>  $user));
        return $this->render('add_reservation/ARReservation.html.twig',[
            "Reservations"=>$ListReservation]);
    }

}
