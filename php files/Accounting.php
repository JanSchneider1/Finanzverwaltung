<?php

/**
 * Class Accounting
 * @author Albers
 */
class Accounting {

    private $accountingID;
    private $value;
    private $isPositive;
    private $date;
    private $name;
    private $categoryID;

    /**
     * Accounting constructor.
     * @param $id
     * @param $value
     * @param $isPositive
     * @param $date
     * @param $name
     * @param $categoryID
     */
    public function __construct($id, $value, $isPositive, $date, $name, $categoryID) {

        $this->accountingID = $id;
        $this->value = $value;
        $this->isPositive = $isPositive;
        $this->date = $date;
        $this->name = $name;
        $this->categoryID = $categoryID;
    }

    /**
     * @return mixed
     */
    public function getAccountingID()
    {
        return $this->accountingID;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getIsPositive()
    {
        return $this->isPositive;
    }

    /**
     * @param mixed $isPositive
     */
    public function setIsPositive($isPositive)
    {
        $this->isPositive = $isPositive;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCategoryID()
    {
        return $this->categoryID;
    }

    /**
     * @param mixed $categoryID
     */
    public function setCategoryID($categoryID)
    {
        $this->categoryID = $categoryID;
    }
}

//$acc[0] = new Accounting(10, 20, 0, '2018-12-24', 'tanken', 5);
//var_dump($acc[0]);