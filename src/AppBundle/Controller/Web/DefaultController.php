<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $calendars = $this->getDoctrine()->getRepository('AppBundle:Calendar')->findAll();

        return $this->render('AppBundle:Default:index.html.twig', [
            'calendars' => $calendars,
        ]);
    }

    /**
     * @Route("/calendar/{id}", name="show_calendar")
     */
    public function showCalendarAction($id)
    {
        $calendar = $this->getDoctrine()->getRepository('AppBundle:Calendar')->find($id);

        if ($calendar === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('AppBundle:Default:show-calendar.html.twig', [
            'calendar' => $calendar,
        ]);
    }
}
