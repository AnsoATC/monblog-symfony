<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/ajax/comments', name: 'app_comment')]
    public function add(Request $request): Response
    {
        $commentData = $request->request->all('comment');

        if (!$this->isCsrfTokenValid('comment-add', $commentData['_token'])) {
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN'
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }
}
