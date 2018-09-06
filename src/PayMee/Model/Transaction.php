<?php

namespace PayMee\Model;

/**
 * Class Transaction
 *
 * @package PayMee\Model
 */
class Transaction
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
     * @var Shopper
     */
    public $shopper;

    /**
     * @var Instructions
     */
    public $instructions;
	
	
	public static function fromJson($json){
		$trans = new Transaction();
		$res = $json->response;
		
		$trans->status = $json->status;
		$trans->message = $json->message;
		$trans->referenceCode = $res->referenceCode;
        $trans->amount = $res->amount;
        $trans->saleCode = $res->saleCode;
		$trans->uuid = $res->uuid;
		$trans->shopper = Shopper::fromJson($res->shopper);
		$trans->instructions = Instructions::fromJson($res->instructions);
		
		return $trans;
	}
	
	
	/** 
	 * Set the value of status
	 *
	 * @return string 
	 */
	public function getStatus(){
		return $this->status;
	}

	/** 
	 * Set the value of message
	 *
	 * @return string 
	 */
	public function getMessage(){
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
} 
