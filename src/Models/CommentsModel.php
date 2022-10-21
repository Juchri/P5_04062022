<?php
namespace App\Models;

class CommentsModel extends Model
{
    protected $id;
    protected $content;
    protected $created_at;
    protected $is_valid;
    protected $user_id;
    protected $post_id;
    protected $author;

    public function __construct()
    {
        $this->table = 'comments';
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

      /**
     * Get the value of post_id
     */ 
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * Set the value of post_id
     *
     * @return  self
     */ 
    public function setPostId($postId)
    {
        $this->post_id = $postId;

        return $this;
    }

    /**
     * Get the value of is_valid
     */ 
    public function getIsValid()
    {
        return $this->is_valid;
    }

    /**
     * Set the value of is_valid
     *
     * @return  self
     */ 
    public function setIsValid($isValid)
    {
        $this->is_valid = $isValid;

        return $this;
    }
}