<?php


namespace App\Controller;


use App\Entity\Appointment;
use App\Form\AppointmentCreateType;
use App\Form\AppointmentUpdateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that handles appointments between doctors and patients.
 *
 * Class AppointmentController
 * @package App\Controller
 *
 * @Route("/appointment", name="appointment.")
 */
class AppointmentController extends Controller
{
    /**
     * @param Appointment $appointment
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/view", name="view", methods={"GET"})
     */
    public function view(Appointment $appointment, Request $request)
    {
        return $this->render('forms/post/view.html.twig', [
            'post' => $appointment
        ]);
    }

    /**
     * @param Request $request
     * @Route("/create", name="create")
     * @return Response|null
     */
    public function create(Request $request)
    {
        $appointment = new Appointment();
        $appointment->setPatient($this->getUser());

        $form = $this->createForm(AppointmentCreateType::class, $appointment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($appointment);
            $em->flush();

            $this->addFlash('success', 'Запись успешно создана.');

            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        return $this->render('forms/appointment/create.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/appointment.svg',
            'title' => 'Запись к врачу'
        ]);
    }

    /**
     * @param Appointment $appointment
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/update", name="update")
     */
    public function update(Appointment $appointment, Request $request)
    {
        $form = $this->createForm(AppointmentUpdateType::class, $appointment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($appointment);
            $em->flush();

            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        return $this->render('forms/appointment/update.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/appointment.svg',
            'title' => 'Запись к врачу - редактирование'
        ]);
    }

    /**
     * @param Appointment $appointment
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Appointment $appointment, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($appointment);
        $em->flush();

        $this->addFlash('success', 'Запись успешно отменена.');

        return new RedirectResponse($this->generateUrl('page.profile'));
    }
}