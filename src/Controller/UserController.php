<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\DoctorUpdateType;
use App\Form\PatientUpdateType;
use App\Form\DoctorCreateType;
use App\Form\RegisterType;
use App\Form\UserPasswordUpdateType;
use App\Service\UserManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User as AdminUser;

/**
 * Controller that handles CRUD operations of User entity.
 *
 * Class UserController
 * @package App\Controller
 *
 * @Route("/user", name="user.")
 */
class UserController extends AbstractController
{

    /**
     * @param UserManager $userManager
     * @param Request $request
     * @return Response|null
     * @Route("/register", name="register")
     */
    public function register(UserManager $userManager, Request $request)
    {
        return $this->create($userManager, $request);
    }

    /**
     * @param UserManager $userManager
     * @param Request $request
     * @return Response|null
     * @Route("/create", name="create")
     */
    public function create(UserManager $userManager, Request $request)
    {
        $currentUser = $this->getUser();

        $user = new User();
        $user->setType(User::USERTYPE_PATIENT);

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->hashPassword($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $username = $user->getName();
            $this->addFlash('success', "$username, Ваш профиль создан, введите данные для того чтобы войти.");

            return new RedirectResponse($this->generateUrl('app_login'));
        }

        return $this->render('forms/user/main.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/user-black.svg',
            'title' => 'Регистрация'
        ]);
    }

    /**
     * @param UserManager $userManager
     * @param Request $request
     * @return Response|null
     * @Route("/create/doctor", name="create_doctor")
     */
    public function createDoctor(UserManager $userManager, Request $request)
    {
        $currentUser = $this->getUser();

        if (!($currentUser && $currentUser instanceof AdminUser)) {
            $this->redirect($this->generateUrl('page.home'));
        }

        $user = new User();
        $user->setType(User::USERTYPE_DOCTOR);
        $user->setPlainPassword(User::RESET_PASSWORD_VALUE);

        $form = $this->createForm(DoctorCreateType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->hashPassword($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $email = $user->getEmail();
            $this->addFlash('success', "Пользователь $email успешно создан.");

            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        return $this->render('forms/user/main.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/user-black.svg',
            'title' => 'Регистрация врача'
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/update", name="update")
     */
    public function update(User $user, Request $request)
    {
        $formType = $user->getType() === User::USERTYPE_PATIENT ?
            PatientUpdateType::class :
            DoctorUpdateType::class;
        $form = $this->createForm($formType, $user);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Данные успешно обновлены.');

            return new RedirectResponse($this->generateUrl('page.profile'));
        }


        return $this->render('forms/user/main.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/user-edit.svg',
            'title' => 'Изменение данных'
        ]);
    }

    /**
     * @param User $user
     * @param UserManager $userManager
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/password", name="password")
     */
    public function updatePassword(User $user, UserManager $userManager, Request $request)
    {
        $form = $this->createForm(UserPasswordUpdateType::class, $user);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->hashPassword($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Пароль успешно обновлен.');

            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        return $this->render('forms/user/main.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/user-edit.svg',
            'title' => 'Изменение пароля'
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(User $user, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();

        $this->addFlash('success', 'Пользователь успешно удален.');

        return new RedirectResponse($this->generateUrl('page.home'));
    }

    /**
     * @param User $user
     * @param UserManager $userManager
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/reset", name="reset")
     */
    public function resetPassword(User $user, UserManager $userManager, Request $request)
    {
        $user->setPlainPassword(User::RESET_PASSWORD_VALUE);
        $userManager->hashPassword($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'Пароль успешно сброшен к значению по умолчанию.');

        return new RedirectResponse($this->generateUrl('page.profile'));
    }
}