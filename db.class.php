<?php
class Database {
    private static $instance;
    private $handle;
    private function __construct(){
        $this->handle = new mysqli('localhost', 'root', '', 'tinybbs');;
        if ($this->handle->connect_error)
            throw new Exception('Can\'t connect to DB: '.$this->handle->connect_error,$this->handle->connect_errno);
        $this->handle->set_charset("utf8");
    }
    public static function getInstance(){
        if ( is_null( self::$instance ) )
            self::$instance = new self();
        return self::$instance;
    }
    public function getHandle(){return $this->handle;}
    public function fetchPosts($parent=0){
        if(!is_numeric($parent) || is_float($parent) || $parent < 0)
            throw new Exception("Can't assign parent to non-numeric value", '100');
        $results = $this->handle->query("SELECT * FROM posts WHERE parent_id = $parent ORDER BY date");
        if($this->handle->error)
            throw new Exception('Can\'t fetch posts from the DB: '.$this->handle->error,$this->handle->errno);
        $posts = array();
        while($obj = $results->fetch_object())
            array_push($posts,new Post($obj->message,$obj->parent_id,$obj->id,$obj->date));
        $results->close();
        return $posts;     
    }
    public function addPost(Post $post){
        $this->handle->query('INSERT INTO posts (parent_id,message) VALUES (\'' . $post->getParent(true) . '\',\'' . $post->getMessage(true) . '\');');
        if($this->handle->error)
            throw new Exception('Can\'t fetch posts from the DB: '.$this->handle->error,$this->handle->errno);
        return $this->handle->insert_id;
    }
}?>