<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/ajax/comments', name: 'comment_add', methods: ['POST'])]
    public function addComment(Request $request, ArticleRepository $articleRepo, EntityManagerInterface $em, UserRepository $userRepo, CommentRepository $commentRepo): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json([
                'code' => 'NOT_AUTHENTICATED'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = $request->request->all('comment');

        if (!$this->isCsrfTokenValid('comment-add', $data['_token'])) {
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN'
            ], Response::HTTP_BAD_REQUEST);
        }

        $article = $articleRepo->findOneBy(['id' => $data['article']]);

        if (!$article) {
            return $this->json([
                'code' => 'ARTICLE_NOT_FOUND'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->getUser();

        if(!$user){
            return $this->json([
                'code' => 'USER_NOT_AUTHENTICATED_FULLY'
            ], Response::HTTP_BAD_REQUEST);
        }

        $comment = new Comment($article);
        $comment->setContent($data['content']);
        $comment->setUser($user);
        $comment->setCreatedAt(new \DateTime());

        $em->persist($comment);
        $em->flush();

        $html = $this->renderView('comment/index.html.twig', [
            'comment' => $comment
        ]);

        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'numberOfComments' => $commentRepo->count(['article' => $article]),
            'message' => $html,
        ]);
    }
}
