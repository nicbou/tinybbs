<?php
require_once('db.class.php');
require_once('post.class.php');

class Forum {
    private $tree = array();
    private $parent = 0;
    
    function __construct($id=0,$newreply=NULL){
        
    }
    function makeForum($parent=0){
        if(is_numeric($parent) && !is_float($parent) && $parent>=0)
            return($this->formatPosts($this->fetchSubposts($parent)));
    }
    function formatPosts(Array $posts,$showlink=false){
        $output = '';
        foreach($posts as $post){
            $output .= '<li><a name='.$post['post']->getId().'></a><p>'. $post['post']->getMessage() .'</p>';
            if($showlink)
                $output .= '<a href=\'?id='.$post['post']->getParent().'\'>Permalink</a>';
            $output .= $this->makeReplyForm($post['post']->getId());
            $output .= "</p>";
            $output .= $this->formatPosts($post['children'],true);
            $output .= "</li>";
        }
        $output = '<ul>'.$output.'</ul>';
        return $output;
    }
    function makeReplyForm($id){
        return "<form action='#$id' method='POST'>
            <input type='hidden' name='parent' value='$id'/>
            <textarea name='message'></textarea>
            <input type='submit' value='Submit'/>
            </form>";
    }
    function fetchSubposts($parent=0){
        $node = array();
        $posts = Database::getInstance()->fetchPosts($parent);
        foreach($posts as $post){
            $node[$post->getId()]['post'] = $post;
            $node[$post->getId()]['children'] = $this->fetchSubposts($post->getId());
        }
        return $node;
    }
    function reply($message,$parent=0){
        Database::getInstance()->addPost(new Post($message, $parent));
    }
}
?>