<?php


namespace App\Controller;


use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that handles news posting feature.
 *
 * Class PostController
 * @package App\Controller
 *
 * @Route("/post", name="post.")
 */
class PostController extends Controller
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
     * @Route("/create", name="create")
     * @return Response|null
     */
    public function create(Request $request)
    {
        $post = new Post();
        $post->setAuthor($this->getUser());

        $form = $this->createForm(PostType::class, $post);

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
     * @param Post $post
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/update", name="update")
     */
    public function update(Post $post, Request $request)
    {
        $form = $this->createForm(PostType::class, $post);

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
     * @param Post $post
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Post $post, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        // TODO
        return $this->render('post/create.html.twig');
    }
}