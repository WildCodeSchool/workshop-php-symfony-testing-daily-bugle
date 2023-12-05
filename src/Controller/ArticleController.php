<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Service\ReadingTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ArticleController extends AbstractController
{
    #[Route('/recent-articles', name: 'app_article_index')]
    public function recentArticles(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findBy([], ['date' => 'desc'], 4)
        ]);
    }

    #[Route('/articles/{id<\d+>}', name: 'app_article_show')]
    public function show(
        Article $article,
        Request $request,
        CommentRepository $commentRepository,
        ReadingTime $readingTime
    ): Response {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setArticle($article);
            $comment->setCreatedAt(new \DateTimeImmutable());
            $commentRepository->save($comment, true);
            return $this->redirectToRoute('app_article_show', [
                'id' => $article->getId(),
                '_fragment' => 'comment'
            ]);
        }
        return $this->render('article/show.html.twig', [
            'reading_time' => $readingTime->calculate($article->getContent()),
            'article' => $article,
            'form' => $form
        ]);
    }
}
