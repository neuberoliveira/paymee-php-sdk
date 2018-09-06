<?php

namespace PayMee\Model;

/**
 * Class Document
 *
 * @package PayMee\Model
 */
class Document
{
	/**
	 * @var string
	 */
	public $type;
	
	/**
	 * @var string
	 */
	public $number;
	
	
	public static function fromJson($json){
		$doc = new Document();
		$doc->type = $json->type;
		$doc->number = $json->number;
		
		return $doc;
	}
	
	/** 
	 * Get the value of type
	 * 
	 * @return string
	 */
	public function getType(){
		return $this->type;
	}

	/** 
	 * Get the value of number
	 * 
	 * @return string 
	 */
	public function getNumber(){
		return $this->number;
	}
}
