<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ArticleService
{
    public function __construct(
        private RequestStack $requestStack,
        private ArticleRepository $articleRepo,
        private PaginatorInterface $paginator,
        private OptionService $optionService
    ) {

    }

    public function getPaginatedArticles(?Category $category = null)
    {
        $request = $this->requestStack->getMainRequest();
        $articlesQuery = $this->articleRepo->findForPagination($category);
        $page = $request->query->getInt('page', 1);
        $limit = $this->optionService->getValue('blog_articles_limit');

        return $this->paginator->paginate($articlesQuery, $page, $limit);
    }
}