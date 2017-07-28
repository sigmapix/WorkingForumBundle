<?php

namespace Yosimitso\WorkingForumBundle\Entity;

use Yosimitso\WorkingForumBundle\Entity\Post as Post;
use Yosimitso\WorkingForumBundle\Entity\User as User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PostVote
 *
 * @ORM\Table(name="post_vote")
 * @ORM\Entity(repositoryClass="Yosimitso\WorkingForumBundle\Repository\PostVoteRepository")
 */
class PostVote
{
    const VOTE_UP = 1;
    const VOTE_DOWN = 2;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Yosimitso\WorkingForumBundle\Entity\Post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     */
    private $post;

    /**
     * @var int
     *
     * @ORM\Column(name="voteType", type="integer")
     */
    private $voteType;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Yosimitso\WorkingForumBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set post
     *
     * @param Post $post
     *
     * @return PostVote
     */
    public function setPost(Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set voteType
     *
     * @param integer $voteType
     *
     * @return PostVote
     */
    public function setVoteUpNb($voteType)
    {
        $this->voteType = $voteType;

        return $this;
    }

    /**
     * Get voteType
     *
     * @return int
     */
    public function getVoteType()
    {
        return $this->voteType;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return PostVote
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}

