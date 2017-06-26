<?php

namespace AppBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/booking")
 */
class BookingController extends Controller
{
    /**
     * @Route("/create", name="booking_create")
     */
    public function createAction(Request $request)
    {
        
    }

    /**
     * @Route("/{id}/delete", name="booking_delete")
     */
    public function deleteAction($id)
    {
        return $this->render('AppBundle:Booking:delete.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/{id}/edit", name="booking_edit")
     */
    public function editAction($id)
    {
        return $this->render('AppBundle:Booking:edit.html.twig', array(
            // ...
        ));
    }

}
