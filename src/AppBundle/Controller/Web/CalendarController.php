<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\Calendar;
use AppBundle\Form\CalendarType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/calendar")
 */
class CalendarController extends Controller
{
    /**
     * @Route("/create", name="calendar_create")
     */
    public function createAction(Request $request)
    {
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
        ));
    }

    /**
     * @Route("/", name="calendar_show")
     */
    public function showAction()
    {
        $user = $this->getUser();

        $calendar = $user->getCalendar();

        return $this->render('AppBundle:Calendar:show.html.twig', array(
            'calendar' => $calendar,
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
            'attr' => array('class' => 'update'),
        ));

        if ($request->getMethod() != 'GET') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $calendar->setUser($this->getUser());

                $em = $this->getDoctrine()->getManager();
                $em->persist($calendar);
                $em->flush();
            }
        }

        return $this->render('AppBundle:Calendar:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
