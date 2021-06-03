<?php


namespace App\Controller;


use App\Entity\Post;
use App\Form\PostCreateType;
use App\Form\PostUpdateType;
use App\Util\PathHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @param Post $post
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/view", name="view", methods={"GET"})
     */
    public function view(Post $post, Request $request)
    {
        return $this->render('forms/post/view.html.twig', [
            'post' => $post
        ]);
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

        $form = $this->createForm(PostCreateType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $files = $request->files->get('post_create');
            /** @var UploadedFile $file */
            $file = array_shift($files);
            if ($file) {
                $extension = $file->guessClientExtension();
                if (in_array($extension, Post::ALLOWED_IMAGE_EXTENSIONS)) {
                    $filename = PathHelper::generateFilename().'.'.$extension;
                    $file->move($this->getParameter('uploads_dir'), $filename);

                    $post->setImage($filename);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($post);
                    $em->flush();

                    $this->addFlash('success', 'Пост успешно опубликован.');

                    return new RedirectResponse($this->generateUrl('page.home'));
                } else {
                    $this->addFlash('fail', 'Прикрепленный файл не является изображением.');
                }
            } else {
                $this->addFlash('fail', 'Прикрепление изображения обязательно.');
            }
        }

        return $this->render('forms/post/main.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/edit.svg',
            'title' => 'Публикация'
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
        $form = $this->createForm(PostUpdateType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $files = $request->files->get('post_update');
            /** @var UploadedFile $file */
            $file = ($files) ? array_shift($files) : null;
            if ($file) {
                $extension = $file->guessClientExtension();
                if (in_array($extension, Post::ALLOWED_IMAGE_EXTENSIONS)) {
                    $filename = PathHelper::generateFilename().'.'.$extension;
                    $file->move($this->getParameter('uploads_dir'), $filename);

                    $post->setImage($filename);
                } else {
                    $this->addFlash('fail', 'Прикрепленный файл не является изображением, изображение не обновлено.');
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        return $this->render('forms/post/main.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/edit.svg',
            'title' => 'Изменение публикации'
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

        $this->addFlash('success', 'Пост успешно удален.');

        return new RedirectResponse($this->generateUrl('page.profile'));
    }
}