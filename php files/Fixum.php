<?php

/**
 * Class Fixum
 * @author Albers
 */
class Fixum {

    private $fixumID;
    private $value;
    private $isPositive;
    private $startDate;
    private $lastUsedDate;
    private $name;
    private $frequency;
    private $categoryID;

    /**
     * Fixum constructor.
     * @param $fixumID
     * @param $value
     * @param $isPositive
     * @param $startDate
     * @param $lastUsedDate
     * @param $name
     * @param $frequency
     * @param $categoryID
     */
    public function __construct($fixumID, $value, $isPositive, $startDate, $lastUsedDate, $name, $frequency, $categoryID) {
        $this->fixumID = $fixumID;
        $this->value = $value;
        $this->isPositive = $isPositive;
        $this->startDate = $startDate;
        $this->lastUsedDate = $lastUsedDate;
        $this->name = $name;
        $this->frequency = $frequency;
        $this->categoryID = $categoryID;
    }

    /**
     * @return mixed
     */
    public function getFixumID()
    {
        return $this->fixumID;
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
    public function getisPositive()
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
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getLastUsedDate()
    {
        return $this->lastUsedDate;
    }

    /**
     * @param mixed $lastUsedDate
     */
    public function setLastUsedDate($lastUsedDate)
    {
        $this->lastUsedDate = $lastUsedDate;
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
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param mixed $frequency
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
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

//$fix = new Fixum(1, 50, 0, '2018-01-01', null, 'VRR-Ticket', 'MONTH', 4);
//var_dump($fix);