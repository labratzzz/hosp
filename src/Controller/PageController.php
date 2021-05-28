<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    public function homePage(Request $request)
    {
        return $this->render('home/main.html.twig');
    }

    /**
     * @Route("", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function aboutPage(Request $request)
    {
        return $this->render('about/main.html.twig');
    }

    /**
     * @Route("", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function contactsPage(Request $request)
    {
        return $this->render('contacts/main.html.twig');
    }

    /**
     * @Route("", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function servicesPage(Request $request)
    {
        return $this->render('services/main.html.twig');
    }
}