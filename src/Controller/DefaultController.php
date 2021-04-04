<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Edition\EntityBase\Post as BasePost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/default")
     */
    public function index(): Response
    {
//        $comment = $this->em->find(Comment::class, 1);
//        $comment->getPost()->getTitle();

        $basePostRepository = $this->em->getRepository(BasePost::class);
        assert($this->getMetaName(BasePost::class) == BasePost::class);
        assert($this->getMetaName(Post::class)     == Post::class);
        assert($this->getMetaName(BasePost::class) == Post::class);
        assert($basePostRepository != $this->em->getRepository(BasePost::class));

        return new Response();
    }

    private function getMetaName($class)
    {
        return $this->em->getClassMetadata($class)->getName();
    }
}
