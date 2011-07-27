<?php
require_once('db.php');
require_once('post.php');
class Forum{
	private $parent=0;
	function __construct($echo=1,$id=0,$newreply=NULL){
		$this->parent=isset($_GET['id'])&&is_numeric($_GET['id'])&&!is_float($_GET['id'])&&$_GET['id']>=0?$_GET['id']:0;
		if(isset($_POST['msg'])&&isset($_POST['parent']))
			$this->reply($_POST['msg'],$_POST['parent']);
		echo($echo?$this->make($this->parent):'');
	}
	function make($parent=0){
		if(is_numeric($parent) && !is_float($parent) && $parent>=0){
			$out=($this->formatPosts($this->getSubPosts($parent)));
			return $this->makeReplyForm($parent).$out;
		}
		else
			throw new Exception('Invalid parent thread specified', 102);
	}
	function formatPosts(Array $posts){
		$output='';
		foreach($posts as $post){
			$output .='<li>
			<a class="id" id="'.$post['post']->getId().'"></a>
			<p>'.htmlentities($post['post']->getMessage(),ENT_NOQUOTES,"UTF-8").'</p>'
			.$this->makeReplyForm($post['post']->getId())
			.'<span class="date">'.date('M j, Y',$post['post']->getDate()).'</span>
			<a href=\'?id='.$post['post']->getParent().'#'.$post['post']->getId().'\'>Permalink</a>
			<a onclick="reply(this)">Reply</a>'
			.$this->formatPosts($post['children'])
			."</li>";
		}
		$output='<ul>'.$output.'</ul>';
		return $output;
	}
	private function makeReplyForm($id){
		return "<form action='#$id' method='POST'><input type='hidden' name='parent' value='$id'/><textarea required name='msg'></textarea><input type='submit' value='Submit'/></form>";
	}
	private function getSubPosts($parent=0){
		$node=array();
		$posts=DB::getInstance()->fetchPosts($parent);
		foreach($posts as $post){
			$node[$post->getId()]['post']=$post;
			$node[$post->getId()]['children']=$this->getSubPosts($post->getId());
		}
		return $node;
	}
	function reply($msg,$parent=0){
		DB::getInstance()->addPost(new Post($msg,$parent));
	}
}