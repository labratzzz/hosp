<?php


namespace App\Controller;


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
     * @Route("home", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function homePage(Request $request)
    {
        return $this->render('home/main.html.twig');
    }

    /**
     * @Route("about", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function aboutPage(Request $request)
    {
        return $this->render('about/main.html.twig');
    }

    /**
     * @Route("contacts", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function contactsPage(Request $request)
    {
        return $this->render('contacts/main.html.twig');
    }

    /**
     * @Route("services", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function servicesPage(Request $request)
    {
        return $this->render('services/main.html.twig');
    }
}