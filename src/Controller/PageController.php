<?php


namespace App\Controller;


use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
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
class PageController extends AbstractController
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
        $page = $request->query->get('page', 1);

        /** @var QueryBuilder $qb */
        $qb = $this->getDoctrine()->getRepository(Post::class)->getPostQueryBuilder();

        $posts = $this->paginate($qb->getQuery(), $page, $postPages);
        return $this->render('pages/home/main.html.twig', [
            'posts' => $posts,
            'post_pages' => $postPages,
            'current_page' => $page
        ]);
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
            $users = $this->getDoctrine()->getRepository(User::class)->findAll();
            return $this->render('pages/profile/admin.html.twig', [
                'users' => $users
            ]);
        }

        if ($user->getType() == User::USERTYPE_PATIENT) {
            $appointments = $user->getAppointmentsAsPatient();

            return $this->render('pages/profile/patient.html.twig', [
                'user' => $user,
                'appointments' => $appointments
            ]);
        } else {
            $posts = $user->getPosts();
            $appointments = $user->getAppointmentsAsDoctor();

            return $this->render('pages/profile/doctor.html.twig', [
                'posts' => $posts,
                'user' => $user,
                'appointments' => $appointments
            ]);
        }
    }
}