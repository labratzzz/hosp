<?php


namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends Controller
{
    /**
     * @Route("/lucky/number", methods={"GET"})
     */
    public function numberAction(Request $request)
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @Route("/users/{id}", methods={"GET"})
     */
    public function userTest(User $user, Request $request)
    {
        return new Response(
            '<html><body>Found user: '.strval($user).'</body></html>'
        );
    }
}