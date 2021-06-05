<?php


namespace App\Controller;


use App\Entity\Appointment;
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
        $qb = $this->getDoctrine()->getRepository(Post::class)->getAllQueryBuilder();

        $posts = $this->paginate($qb->getQuery(), $page, $postPages);
        return $this->render('pages/home/main.html.twig', [
            'posts' => $posts,
            'post_page' => $page,
            'post_pages' => $postPages
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
            $userPage = $request->query->get('upage', 1);

            $qb = $this->getDoctrine()->getRepository(User::class)->getAllQueryBuilder();
            $users = $this->paginate($qb->getQuery(), $userPage, $userPages);

            return $this->render('pages/profile/admin.html.twig', [
                'users' => $users,
                'user_page' => $userPage,
                'user_pages' => $userPages
            ]);
        }

        $appointmentPage = $request->query->get('apage', 1);

        /** @var QueryBuilder $qb */
        $qb = $this->getDoctrine()->getRepository(Appointment::class)->getUserAppointmentsQueryBuilder($user);
        $appointments = $this->paginate($qb->getQuery(), $appointmentPage, $appointmentPages);

        if ($user->getType() == User::USERTYPE_PATIENT) {
            return $this->render('pages/profile/patient.html.twig', [
                'user' => $user,
                'appointments' => $appointments,
                'app_page' => $appointmentPage,
                'app_pages' => $appointmentPages,
            ]);
        } else {
            $postPage = $request->query->get('ppage', 1);

            /** @var QueryBuilder $qb */
            $qb = $this->getDoctrine()->getRepository(Post::class)->getUserPostsQueryBuilder($user);
            $posts = $this->paginate($qb->getQuery(), $postPage, $postPages);

            return $this->render('pages/profile/doctor.html.twig', [
                'user' => $user,
                'posts' => $posts,
                'post_page' => $postPage,
                'post_pages' => $postPages,
                'appointments' => $appointments,
                'app_page' => $appointmentPage,
                'app_pages' => $appointmentPages,
            ]);
        }
    }
}