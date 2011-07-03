<?php
require_once('db.class.php');
require_once('post.class.php');

class Forum {
	private $tree=array();
	private $parent=0;

	function __construct($id=0,$newreply=NULL){

	}
	function makeForum($parent=0){
		if(is_numeric($parent) && !is_float($parent) && $parent>=0){
			$out=($this->formatPosts($this->fetchSubposts($parent)));
			return $this->makeReplyForm($parent).$out;
		}
		else
			throw new Exception('Invalid parent thread specified', 102);
	}
	function formatPosts(Array $posts){
		$output='';
		foreach($posts as $post){
			$output.='<li><a name='.$post['post']->getId().'></a><p>'.htmlentities($post['post']->getMessage(),ENT_NOQUOTES,"UTF-8").'</p>';
			$output.="</p>";
			$output.=$this->makeReplyForm($post['post']->getId());
			$output.='<a href=\'?id='.$post['post']->getParent().'#'.$post['post']->getId().'\'>Permalink</a>';
			$output.=$this->formatPosts($post['children']);
			$output.="</li>";
		}
		$output='<ul>'.$output.'</ul>';
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
		$node=array();
		$posts=Database::getInstance()->fetchPosts($parent);
		foreach($posts as $post){
			$node[$post->getId()]['post']=$post;
			$node[$post->getId()]['children']=$this->fetchSubposts($post->getId());
		}
		return $node;
	}
	function reply($message,$parent=0){
		Database::getInstance()->addPost(new Post($message, $parent));
	}
}
?>