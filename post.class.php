<?php
require_once('db.class.php');
class Post {
	private $msg;
	private $parent;
	private $id;
	private $date;
	function __construct($msg,$parent,$id=NULL,$date=NULL){
		$this->msg=$msg;
		$this->setParent($parent);
		if($id!=NULL)$this->setId($id);
		if($date!=NULL)$this->setDate($date);
	}
	function save(){
		return Database::getInstance()->addPost($this);
	}
	function setParent($parent){
		if(is_numeric($parent) && !is_float($parent) && $parent >=0)
			$this->parent=$parent;
		else
			throw new Exception("Can't assign parent to non-numeric value", '100');
	}
	function setId($id){
		if(is_numeric($id) && !is_float($id) && $id >=0)
			$this->id=$id;
		else
			throw new Exception("Can't assign id to non-numeric value", '100');
	}
	function setDate($date){
		$this->date=$date;
	}
	function getParent($escape=false){return ($escape ? Database::getInstance()->getHandle()->real_escape_string(($this->parent)) : $this->parent);}
	function getMessage($escape=false){return ($escape ? Database::getInstance()->getHandle()->real_escape_string(($this->msg)) : $this->msg);}
	function getId(){return $this->id;}
	function getDate(){return $this->date;}
}