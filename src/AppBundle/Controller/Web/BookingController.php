<?php

namespace AppBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Booking;
use AppBundle\Form\BookingType;

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
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        if ($request->isMethod("POST")) {
            $form->submit($request->request->all());

            $endDate = clone $booking->getStartTime();
            $hours = intval($booking->getCalendar()->getStepMinutes()/60);
            $minutes = $booking->getCalendar()->getStepMinutes()%60;

            $endDate->add(new \DateInterval("PT".$hours."H".$minutes."M"));
            $booking->setEndTime($endDate);

            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return JsonResponse::create([
                    'title' => $booking->getNote(),
                    'startTime' => $booking->getStartTime()->format('Y-m-d H:i'),
                    'endTime' => $booking->getEndTime()->format('Y-m-d H:i'),
                ]);
            }
        }
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
