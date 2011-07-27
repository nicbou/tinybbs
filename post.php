<?php
require_once('db.php');
class Post {
	protected $msg;
	protected $parent;
	protected $id;
	protected $date;
	function __construct($msg,$parent,$id=NULL,$date=NULL){
		$this->setMessage($msg);
		$this->setParent($parent);
		if($id!=NULL)$this->setId($id);
		if($date!=NULL)$this->setDate($date);
	}
	function save(){
		return DB::getInstance()->addPost($this);
	}
	function setParent($parent){
		if(is_numeric($parent) && !is_float($parent) && $parent >=0)
			$this->parent=$parent;
		else
			throw new Exception("Parent has to non-numeric value", '100');
	}
	function setMessage($msg){
		$this->msg=$msg;
	}
	function setId($id){
		if(is_numeric($id) && !is_float($id) && $id >=0)
			$this->id=$id;
		else
			throw new Exception("ID has to non-numeric value", '100');
	}
	function setDate($date){
		$this->date=$date;
	}
	function getParent(){return $this->parent;}
	function getMessage(){return $this->msg;}
	function getId(){return $this->id;}
	function getDate(){return strtotime($this->date);}
}