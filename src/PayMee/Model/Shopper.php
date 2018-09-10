<?php

namespace PayMee\Model;

/**
 * Class Shopper
 *
 * @package PayMee\Model
 */
class Shopper
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
	public $name;
	
    /**
     * @var string
     */
    public $email;

    /**
     * @var Document
     */
    public $document;

	/**
     * @var Phone
     */
    public $phone;

	/**
     * @var BankDetails
     */
    public $bankDetails;

    /**
     * @var string
     */
    public $ip;
	
	
	public static function fromJson($json){
		$shop = new Shopper();
		
		if(isset($json->id)){
			$shop->id = $json->id;
		}
		$shop->name = $json->name;
		$shop->email = $json->email;
		$shop->document = Document::fromJson($json->document);
		$shop->bankDetails = BankDetails::fromJson($json->bankDetails);
		$shop->phone = Phone::fromJson($json->phone);
		
		return $shop;
	}
	
	/**
     * Get the value of id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param string $id
     * @return Shopper
     */
    public function withId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param $email
     * @return Shopper
     */
    public function withEmail($email)
    {
        $this->email = $email;
        return $this;
    }
	
	/**
     * Get the value of name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     * @return Shopper
     */
    public function withName($name)
    {
        $this->name = $name;
        return $this;
	}
	
    /**
     * Get the value of document
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set the value of document
     *
     * @param $document
     * @return Shopper
     */
    public function withDocument(Document $document)
    {
        $this->document = $document;
        return $this;
	}
	
    /**
     * Get the value of phone
     * @return Phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @param $phone
     * @return Shopper
     */
    public function withPhone(Phone $phone)
    {
        $this->phone = $phone;
        return $this;
    }
	
    /**
     * Get the value of bankDetails
     * @return BankDetails
     */
    public function getbankDetails()
    {
        return $this->bankDetails;
    }

    /**
     * Set the value of bankDetails
     *
     * @param $bankDetails
     * @return Shopper
     */
    public function withBankDetails(BankDetails $bankDetails)
    {
        $this->bankDetails = $bankDetails;
        return $this;
    }

    /**
     * Get the value of ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set the value of ip
     *
     * @param string $ip
     * @return Shopper
     */
    public function withIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }
} 
