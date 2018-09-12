<?php

namespace PayMee\Model;
use PayMee\Model\Shopper;
use PayMee\Model\Instructions;
use PayMee\Model\Error;
use \Exception;

/**
 * Class Transaction
 *
 * @package PayMee\Model
 */
class Transaction extends AbstractModel
{
    /**
     * @var string
     */
    public $status;
	
	/**
     * @var string
     */
    public $message;
	
	/**
     * @var string
     */
    public $referenceCode;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $saleCode;

    /**
     * @var string
     */
    public $uuid;

    /**
     * @var string
     */
    public $gatewayURL;

    /**
     * @var Shopper
     */
    public $shopper;

    /**
     * @var Instructions
     */
    public $instructions;

    /**
     * @var Error
     */
    public $error;
	
	/**
	 * {@inheritDoc}
	 */
	public static function fromJson($json)
	{
		$trans = new Transaction();
		$res = $json->response;
		
		$trans->status = $json->status;
		$trans->message = $json->message;
		
		if($json->status >= 0){
			$trans->referenceCode = $res->referenceCode;
			$trans->amount = $res->amount;
			$trans->saleCode = $res->saleCode;
			$trans->uuid = $res->uuid;
			
			if(isset($res->gatewayURL)){
				$trans->gatewayURL = $res->gatewayURL;
			}
			$trans->shopper = Shopper::fromJson($res->shopper);
			
			if(isset($res->instructions)){
				$trans->instructions = Instructions::fromJson($res->instructions);
			}
		}else{
			$trans->error = Error::fromJson($json);
		}
		
		
		return $trans;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function validate()
	{
	}
	
	public function hasInstructions(){
		return !empty($this->instructions) && is_a($this->instructions, 'PayMee\Model\Instructions');
	}
	
	public function hasGatewayURL(){
		return !empty($this->gatewayURL);
	}
	
	public function hasError(){
		return !empty($this->error) && $this->getStatus()<0;
	}
	
	/** 
	 * Set the value of status
	 *
	 * @return string 
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/** 
	 * Set the value of message
	 *
	 * @return string 
	 */
	public function getMessage()
	{
		return $this->message;
	}
	
    /**
     * Get the value of referenceCode
     *
     * @return string
     */
    public function getReferenceCode()
    {
        return $this->referenceCode;
    }
		
    /**
     * Get the value of amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get the value of saleCode
     *
     * @return string
     */
    public function getSaleCode()
    {
        return $this->saleCode;
    }
	
    /**
     * Get the value of uuid
     *
     * @return string
     */
    public function getUUID()
    {
        return $this->uuid;
    }
	
    /**
     * Get the value of gatewayURL
     *
     * @return string
     */
    public function getGatewayURL()
    {
        return $this->gatewayURL;
    }
	
 	/**
     * Get the value of shopper
     *
     * @return Shopper
     */
    public function getShopper()
    {
        return $this->shopper;
    }
	
    /**
     * Get the value of instructions
     *
     * @return Instructions
     */
    public function getInstructions()
    {
        return $this->instructions;
	}
	
    /**
     * Get the value of error
     *
     * @return Error
     */
    public function getError()
    {
        return $this->error;
	}
} 
