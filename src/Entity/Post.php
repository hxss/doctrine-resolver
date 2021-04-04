<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Edition\EntityBase\Post as BasePost;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post extends BasePost
{
}
