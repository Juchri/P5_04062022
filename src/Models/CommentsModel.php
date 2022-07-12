<?php
namespace App\Models;

class CommentsModel extends Model
{   
    protected $id;
    protected $content;
    protected $created_at;
    protected $user_id;
    protected $post_id;

    public function __construct()
    {
        $this->table = 'comments';
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

}