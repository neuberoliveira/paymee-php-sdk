<?php

namespace PayMee\Model;
use \Exception;

/**
 * Class Document
 *
 * @package PayMee\Model
 */
class Error extends AbstractModel
{
	/**
	 * @var integer
	 */
	public $errorCount;
	
	/**
	 * @var array
	 */
	public $errors;
	
	/**
	 * {@inheritDoc}
	 */
	public static function fromJson($json){
		$err = new Error();
		$err->errorCount = $json->errorCount;
		$err->errors = [];
		
		foreach($json->errors as $error){
			$errObj = new stdClass();
			$errObj->field = $error->field;
			$errObj->message = $error->message;
			
			$err->errors = $errObj;
		}
		
		return $err;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function validate()
	{
	}
	
	/** 
	 * Get the value of errorCount
	 * 
	 * @return integer 
	 */
	public function getErrorCount()
	{
		return $this->errorCount;
	}
	
	/** 
	 * Alias for getErrorCount
	 * 
	 * @return array 
	 */
	public function count()
	{
		return $this->getErrorCount();
	}
	
	/** 
	 * Get the value of errors
	 * 
	 * @return array 
	 */
	public function getErrors()
	{
		return $this->errors;
	}
	
	/** 
	 * Flat the errors array with message strings
	 * 
	 * @return array 
	 */
	public function flat()
	{
		$flated = [];
		foreach($this->getErrors() as $err){
			$flated[] = $err->message;
		}
		
		return $flated;
	}
}
