<?php

/**
 * Class User
 * @author Albers
 */
class User {

    private $userID;
    private $firstname;
    private $lastname;
    private $mail;

    /**
     * User constructor.
     * @param $id
     * @param $firstname
     * @param $lastname
     * @param $mail
     */
    public function __construct($id, $firstname, $lastname, $mail) {

        $this->userID = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

}

//$user = new User(1, 'Flo', 'Albers', 'DerFlo@mail.de');
//var_dump($user);