<?php

class Node {
	
	private $name = 'node';
	private $content;
	
	public function __contruct ()
	{
		
	}
	
	public function setName ($name)
	{
		$this->name = $name;
	}
	
	public function getName ()
	{
		return $this->name;
	}
	
	public function setContent ($content)
	{
		$this->content = $content;
	}
	
}