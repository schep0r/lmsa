<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $calendars = $this->getDoctrine()->getRepository('AppBundle:Calendar')->findAll();

        return $this->render('AppBundle:Default:index.html.twig', [
            'calendars' => $calendars,
            'user'      => $user
        ]);
    }
    /**
     * @Route("/profile", name="profile")
     */
    public function profileAction(Request $request)
    {
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            $a = $request->files->all();
            $b = $a['user']['avatar'];

            if ($b) {
                $mimeType = getimagesize($b)['mime'];
                $MimeArray = ["image/gif", "image/jpeg", "image/png"];

                if (!in_array($mimeType, $MimeArray)) {
                    $this->addFlash(
                        'info',
                        'Not valid Images!'
                    );
                    return $this->redirectToRoute('profile', array(
                        'user' => $user,
                    ));
                }
            }
        }


        $userAvatarName = $user->getAvatar();
        $avatarPath = $this->getParameter('avatars_directory');
        $oldAvatar = $avatarPath.'/'.$userAvatarName;

        $userRepository = $this->getDoctrine()->getRepository('AppBundle:User')->find($user->getId());

        $form = $this->createForm(UserType::class, $user);
        $form->add('update', SubmitType::class, array(
            'attr' => array('class' => 'edit btn btn-default btn-flat', 'style' => 'margin-top:10px'),
        ));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $file = $form->getData()->getAvatar();

                $mimeType = getimagesize($file)['mime'];
                $MimeArray = ["image/gif", "image/jpeg", "image/png"];

                if (!in_array($mimeType, $MimeArray)) {
                    $this->addFlash(
                        'info',
                        'Not valid Images!'
                    );
                    return $this->redirectToRoute('profile');
                }
//                var_dump($mimeType, $MimeArray);die;
                if (!$file == null) {

                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move(
                        $this->getParameter('avatars_directory'),
                        $fileName
                    );

                    $user->setAvatar($fileName);
//
                    if (file_exists($oldAvatar)) {
                        unlink($oldAvatar);
                    }
                } else {
                    $user->setAvatar($userAvatarName);
                }

                $em = $this->getDoctrine()->getManager();

                $em->persist($userRepository);

                $em->flush();
            }
        }

        return $this->render('AppBundle:User:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @Route("/calendar/{id}", name="show_calendar")
     */
    public function showCalendarAction($id)
    {
        $user = $this->getUser();
        $calendar = $this->getDoctrine()->getRepository('AppBundle:Calendar')->find($id);

        if ($calendar === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('AppBundle:Default:show-calendar.html.twig', [
            'calendar' => $calendar,
            'user' => $user
        ]);
    }
}
