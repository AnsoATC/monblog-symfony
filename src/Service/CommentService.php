<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CommentService
{
    public function __construct(
        private ArticleRepository $articleRepo,
        private CommentRepository      $commentRepo,
        private EntityManagerInterface $em,
        private NormalizerInterface $normalizer,
        private PaginatorInterface     $paginator,
        private RequestStack           $requestStack,
        private Security               $security
    )
    {

    }

    public function getPaginatedComments(?Article $article = null): PaginationInterface
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 5;

        $commentsQuery = $this->commentRepo->findForPagination($article);

        return $this->paginator->paginate($commentsQuery, $page, $limit);
    }

    public function add(array $data, Article $article): ?Comment
    {
        $comment = new Comment($article, $this->security->getUser());
        $comment->setContent($data['content']);
        $comment->setCreatedAt(new \DateTime());

        $this->em->persist($comment);
        $this->em->flush();

        return $comment;
    }

    public function normalize(Comment $comment): array
    {
        return $this->normalizer->normalize($comment, context: [
            'groups' => 'comment'
        ]);
    }
}