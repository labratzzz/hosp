<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\RegisterType;
use FOS\UserBundle\Model\UserManagerInterface;
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
     * @param Request $request
     * @Route("/register", name="register")
     * @return Response|null
     */
    public function register(Request $request)
    {
        return $this->create($request);
    }

    /**
     * @param Request $request
     * @Route("/create", name="create")
     * @return Response|null
     */
    public function create(Request $request)
    {
        $user = new User();
        $user->setType(User::USERTYPE_PATIENT);

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('user/create.html.twig', [
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

        return $this->render('post/create.html.twig', [
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
        return $this->render('post/create.html.twig');
    }
}