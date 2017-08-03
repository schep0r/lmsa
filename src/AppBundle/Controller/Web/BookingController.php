<?php

namespace AppBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Booking;
use AppBundle\Form\BookingType;
use Symfony\Component\HttpFoundation\Response;

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
        $data = $request->request->all();

        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        if ($request->isMethod("POST")) {

            $form->submit($request->request->all());

            $endDate = clone $booking->getStartTime();
            $hours = intval($booking->getCalendar()->getStepMinutes()/60);
            $minutes = $booking->getCalendar()->getStepMinutes()%60;

            $endDate->add(new \DateInterval("PT".$hours."H".$minutes."M"));
            $endDateTime = $endDate->format('Y-m-d H:i:s');
            $em = $this->getDoctrine()->getManager();

            $booking->setEndTime($endDate);
            $calendar = $em->getRepository('AppBundle:Calendar')->find($data['calendar']);
            $isAtWorkingHoursRepository = $em->getRepository('AppBundle:WorkingHours');
            $AtWorkingHour = $isAtWorkingHoursRepository->isAtWorkingHours($calendar, $data, $endDateTime);

            if ($AtWorkingHour === false) {
                return new JsonResponse(array('message' => 'This time is busy'), 400);
            }

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
    /**
     * @Route("/bookingLoad", name="booking_load")
     */
    public function bookingLoad(Request $request)
    {
        $data = $request->query->all();
        $em = $this->getDoctrine()->getManager();
        $bookingRepository = $em->getRepository('AppBundle:Booking');
        $calendar = $em->getRepository('AppBundle:Calendar')->find($data['id']);

        $bookings = $bookingRepository->findByCalendarIdBetweenDates($calendar, $data);

        $items = [];
        foreach ($bookings as $value)
        {
            $array = [];
            $array['title'] = $value['note'];
            $array['start'] = $value['startTime']->format('Y-m-d H:i');
            $array['end'] = $value['endTime']->format('Y-m-d H:i');
            $items[] = $array;
        }

        $response = new Response(json_encode($items));

        return $response;
    }

}
