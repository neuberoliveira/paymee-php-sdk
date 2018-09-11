<?php

namespace PayMee\Model;
use \Exception;

/**
 * Class Document
 *
 * @package PayMee\Model
 */
class Document extends AbstractModel
{
	const TYPE_CPF = 'CPF';
	const TYPE_CNPJ = 'CNPJ';
	const TYPE_OTHER = 'OTHER';
	/**
	 * @var string
	 */
	public $type;
	
	/**
	 * @var string
	 */
	public $number;
	
	/**
	 * {@inheritDoc}
	 */
	public static function fromJson($json){
		$doc = new Document();
		$doc->type = $json->type;
		$doc->number = $json->number;
		
		return $doc;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function validate()
	{
		if ($this->getNumber() === null) {
			throw new \Exception('shopper.document.number cannot be null or empty.');
		}
	}
	
	/** 
	 * Get the value of type
	 * 
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/** 
	 * Get the value of number
	 * 
	 * @return string 
	 */
	public function getNumber()
	{
		return $this->number;
	}
}
