<?php

namespace PayMee\Model;

/**
 * Class AbstractModel
 *
 * @package PayMee\Model
 */
abstract class AbstractModel 
{
	/**
	 * @throws Exception
	 * @return void
	 */
	public abstract function validate();
	
	/**
	 * Populate Model from an JSON object
	 * 
	 * @param mixed $json object with accessible model properties
	 * @return self
	 */
	public static function fromJson($json)
	{
		throw new Exception('fromJson($json) must be implemented', 1);
	}
}