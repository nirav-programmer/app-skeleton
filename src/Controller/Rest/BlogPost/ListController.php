<?php

declare(strict_types=1);

/*
 * This file is part of AppSkeleton.
 *
 * Copyright (c) 2017 Damien Carcel <damien.carcel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Rest\BlogPost;

use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 *
 * @Route("/api/blog/posts", name="rest_blog_posts_list")
 */
class ListController
{
    /** @var BlogPostRepository */
    private $repository;

    /**
     * @param BlogPostRepository $repository
     */
    public function __construct(BlogPostRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $posts = $this->repository->findAll();

        $normalizedPosts = array_map(function (BlogPost $post) {
            return [
                'id' => $post->id(),
                'title' => $post->title(),
                'content' => $post->content(),
            ];
        }, $posts);

        return new JsonResponse($normalizedPosts);
    }
}
