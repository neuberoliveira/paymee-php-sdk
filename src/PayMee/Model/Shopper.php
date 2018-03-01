<?php

namespace PayMee\Model;

/**
 * Class Shopper
 *
 * @package PayMee\Model
 */
class Shopper
{
    public $id;
    public $fullName;
    public $firstName;
    public $lastName;
    public $cpf;
    public $agency;
    public $account;
    public $email;
    public $mobile;
    public $ip;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param $id
     * @return  self
     */
    public function withId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set the value of cpf
     *
     * @param $cpf
     * @return  self
     */
    public function withCpf($cpf)
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Get the value of agency
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Set the value of agency
     *
     * @param $agency
     * @return  self
     */
    public function withAgency($agency)
    {
        $this->agency = $agency;
        return $this;
    }

    /**
     * Get the value of account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set the value of account
     *
     * @param $account
     * @return  self
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
     * @return  self
     */
    public function withEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of mobile
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set the value of mobile
     *
     * @param $mobile
     * @return  self
     */
    public function withMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * Get the value of ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set the value of ip
     *
     * @param $ip
     * @return  self
     */
    public function withIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Get the value of fullName
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set the value of fullName
     *
     * @param $fullName
     * @return  self
     */
    public function withFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * Get the value of firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @param $firstName
     * @return  self
     */
    public function withFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param $lastName
     * @return $this
     */
    public function withLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
} 
