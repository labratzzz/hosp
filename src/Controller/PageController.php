<?php


namespace App\Controller;


use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controllers that handles general app templates and builds primary visual environment.
 *
 * Class PageController
 * @package App\Controller
 *
 * @Route(name="page.")
 */
class PageController extends Controller
{
    /**
     * @Route("", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function startPage(Request $request)
    {
        return new RedirectResponse('home');

    }

    /**
     * @Route("home", name="home", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function homePage(Request $request)
    {
        return $this->render('pages/home/main.html.twig');
    }

    /**
     * @Route("about", name="about", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function aboutPage(Request $request)
    {
        return $this->render('pages/about/main.html.twig');
    }

    /**
     * @Route("contacts", name="contacts", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function contactsPage(Request $request)
    {
        return $this->render('pages/contacts/main.html.twig');
    }

    /**
     * @Route("services", name="services", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function servicesPage(Request $request)
    {
        return $this->render('pages/services/main.html.twig');
    }

    /**
     * @Route("profile", name="profile", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function profilePage(Request $request)
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            return new Response('ADMIN');
        }

        if ($user->getType() == User::USERTYPE_PATIENT) {
            return $this->render('pages/profile/patient.html.twig', [
                'user' => $user
            ]);
        } else {
            $posts = $this->getDoctrine()->getRepository(Post::class)->findBy(['author' => $user]);
            return $this->render('pages/profile/doctor.html.twig', [
                'posts' => $posts,
                'user' => $user
            ]);
        }
    }
}