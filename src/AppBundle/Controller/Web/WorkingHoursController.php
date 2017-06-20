<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\WorkingHours;
use AppBundle\Form\WorkingHoursType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/system/working-hours")
 */
class WorkingHoursController extends Controller
{
    /**
     * @Route("/", name="working_hours_list")
     */
    public function listAction()
    {
        /** @var \AppBundle\Entity\User $user */
        $user = $this->getUser();
        $calendar = $user->getCalendar();
        $workingHours = $calendar->getWorkingHours();

        return $this->render('AppBundle:WorkingHours:list.html.twig', array(
            'workingHours' => $workingHours,
        ));
    }

    /**
     * @Route("/create", name="working_hours_create")
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        $calendar = $user->getCalendar();
        $workingHours = new WorkingHours();

        $form = $this->createForm(WorkingHoursType::class, $workingHours);
        $form->add('create', SubmitType::class, array(
            'attr' => array('class' => 'create'),
        ));

        $workingHours->setCalendar($calendar);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($workingHours);
                $em->flush();
            }
        }

        return $this->render('AppBundle:WorkingHours:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="working_hours_edit")
     */
    public function editAction(Request $request, $id)
    {
        /** @var \AppBundle\Entity\User $user */
        $user = $this->getUser();
        $calendar = $user->getCalendar();
        $workingHours = $this->getDoctrine()->getRepository('AppBundle:WorkingHours')->find($id);

        if (!$calendar->getWorkingHours()->contains($workingHours)) {
            return $this->createNotFoundException();
        }

        $form = $this->createForm(WorkingHoursType::class, $workingHours);
        $form->add('create', SubmitType::class, array(
            'attr' => array('class' => 'create'),
        ));

        $workingHours->setCalendar($calendar);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($workingHours);
                $em->flush();
            }
        }

        return $this->render('AppBundle:WorkingHours:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/delete", name="working_hours_delete")
     */
    public function deleteAction($id)
    {
        /** @var \AppBundle\Entity\User $user */
        $user = $this->getUser();
        $calendar = $user->getCalendar();
        $workingHours = $this->getDoctrine()->getRepository('AppBundle:WorkingHours')->find($id);

        if (!$calendar->getWorkingHours()->contains($workingHours)) {
            return $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($workingHours);
        $em->flush();

        return $this->redirectToRoute('working_hours_list');
    }
}
