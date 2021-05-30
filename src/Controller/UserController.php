<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\RegisterType;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that handles CRUD operations of User entity.
 *
 * Class UserController
 * @package App\Controller
 *
 * @Route("/user", name="user.")
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @Route("/view", name="view", methods={"GET"})
     */
    public function view(Request $request)
    {

    }

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
        $user = new User();
        $user->setType(User::USERTYPE_PATIENT);

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->hashPassword($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('forms/user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param User $post
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/update", name="update")
     */
    public function update(User $post, Request $request)
    {
        $form = $this->createForm(RegisterType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        }

        return $this->render('forms/user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param User $post
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(User $post, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        // TODO
        return $this->render('forms/user/create.html.twig');
    }
}