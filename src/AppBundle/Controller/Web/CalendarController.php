<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\Calendar;
use AppBundle\Form\CalendarType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Booking;
use AppBundle\Form\BookingType;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("/system/calendar")
 */
class CalendarController extends Controller
{
    /**
     * @Route("/create", name="calendar_create")
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        if ($this->getUser()->getCalendar() !== null) {
            return $this->redirectToRoute('calendar_edit');
        }

        $calendar = new Calendar();
        $calendar->setUser($this->getUser());

        $form = $this->createForm(CalendarType::class, $calendar);
        $form->add('update', SubmitType::class, array(
            'attr' => array('class' => 'update'),
        ));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($calendar);
                $em->flush();
            }
        }

        return $this->render('AppBundle:Calendar:create.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @Route("/", name="calendar_show")
     */
    public function showAction()
    {
        $user = $this->getUser();

        $calendar = $user->getCalendar();

        $workingHours = $calendar->getWorkingHours();

        return $this->render('AppBundle:Calendar:show.html.twig', array(
            'calendar' => $calendar,
            'workingHours' => $workingHours,
            'user' => $user
        ));
    }

    /**
     * @Route("/edit", name="calendar_edit")
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        $calendar = $user->getCalendar();

        $form = $this->createForm(CalendarType::class, $calendar);

        $form->add('update', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-top: 20px'),
        ));

        if ($request->getMethod() != 'GET') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $calendar->setUser($this->getUser());

                $em = $this->getDoctrine()->getManager();
                $em->persist($calendar);
                $em->flush();

                $this->addFlash(
                    'danger',
                    'Your changes were saved!'
                );
                return $this->render('AppBundle:Calendar:edit.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $user
                ));
            }
        }

        return $this->render('AppBundle:Calendar:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
}
