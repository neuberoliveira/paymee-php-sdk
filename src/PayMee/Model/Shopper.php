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
    public $fullName;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $cpf;

    /**
     * @var string
     */
    public $agency;

    /**
     * @var string
     */
    public $account;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $mobile;

    /**
     * @var string
     */
    public $ip;
	
	
	public static function fromJson($json){
		$shop = new Shopper();
		
		$shop->id = $json->id;
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
     * Set the value of cpf
     *
     * @param string $cpf
     * @return $this
     */
    public function withCpf($cpf)
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * Get the value of cpf
     *
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Get the value of agency
     *
     * @return string
     */
    public function getBranch()
    {
        return $this->agency;
    }

    /**
     * Set the value of agency
     *
     * @param string $agency
     * @return Shopper
     */
    public function withBranch($branch)
    {
        $this->agency = $branch;
        return $this;
    }

    /**
     * Get the value of account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set the value of account
     *
     * @param string $account
     * @return Shopper
     */
    public function withAccount($account)
    {
        $this->account = $account;
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
     * Get the value of mobile
     * @return string
     */
    public function getPhone()
    {
        return $this->mobile;
    }

    /**
     * Set the value of mobile
     *
     * @param $mobile
     * @return Shopper
     */
    public function withPhone($phone)
    {
        $this->mobile = $phone;
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

    /**
     * Get the value of fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set the value of fullName
     *
     * @param string $fullName
     * @return Shopper
     */
    public function withFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * Get the value of firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @param string $firstName
     * @return Shopper
     */
    public function withFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Get the value of lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Shopper
     */
    public function withLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
} 
