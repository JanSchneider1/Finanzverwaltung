<?php
/**
 * Created by PhpStorm.
 * User: albers
 * Date: 14.11.2018
 * Time: 13:00
 */

class Repository {

    private $pass = "";
    private $user = "root";
    private $db = "accounting";
    private $host = "localhost";

    private $con;

    /**
     * Initialising the DB Connection
     * @return bool
     */
    function init()
    {
        $this->con = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if($this->con->connect_error){
            die("DB Connection failed: ". $this->con->connect_error);
            return false;
        }

        return true;
    }

    function getAllAccountingsByUser() {

    }

    /**
     * Create a new Accounting
     * @param $UserID
     * @param $Name
     * @param $Value
     * @param $IsPositive
     * @param $Date
     * @param $CategoryID
     * @return bool
     */
    function createAccountingForUser($userID, $name, $value, $isPositive, $date, $categoryID) {

        $SQL = "INSERT INTO Accounting (Value, IsPositive, Date, Name, UserID, CategoryID) 
                VALUES (" . $value . ", " . $isPositive . ", " . $date . ", '" . mysqli_real_escape_string($this->con, $name) . "', " . $userID . ", " . $categoryID . ");";
        echo $SQL . "<br7>";

        if(!mysqli_query($this->con, $SQL)){

            echo "Insert failed: " . mysqli_error($this->con);
            return false;
        }

        return true;
    }

    function deleteAccountingFromUser() {

        return true;
    }

    function getAllCategoriesByUser() {

    }

    /**Creates a new Category for a User
     * @param $userID
     * @param $categoryName
     * @return bool
     */
    function createCategoryForUser($userID, $categoryName){

        $SQL = "INSERT INTO Category (Name, UserID) 
                VALUES ('" . mysqli_real_escape_string($this->con, $categoryName) . "', " . $userID . ");";

        if(!mysqli_query($this->con, $SQL)){

            echo "Insert failed: " . mysqli_error($this->con);
            return false;
        }

        return true;
    }

    function deleteCategoryFromUser() {

        return true;
    }

    function getAllFixaByUser(){

    }

    /** Creates a new Fixum for a User
     *
     * Possible frequency values are: 'DAY', 'WEEK', 'MONTH', 'QUARTER', 'YEAR'
     * @param $userID
     * @param $name
     * @param $value
     * @param $isPositive
     * @param $startDate
     * @param $frequency
     * @param $categoryID
     * @return bool
     */
    function createFixumForUser($userID, $name, $value, $isPositive, $startDate, $frequency, $categoryID) {

        if($frequency == "DAY" || $frequency == "WEEK" || $frequency == "MONTH" || $frequency == "QUARTER" || $frequency == "YEAR") {

            $SQL = "INSERT INTO Fixum (Value, IsPositive, StartDate, Name, Frequency, UserID, CategoryID) 
                    VALUES (" . $value . ", " . $isPositive . ", " . $startDate . ", '" . mysqli_real_escape_string($this->con, $name) . "','" . mysqli_real_escape_string($this->con, $frequency) . "'," . $userID . ", " . $categoryID . ");";

            if (!mysqli_query($this->con, $SQL)) {

                echo "Insert failed: " . mysqli_error($this->con);
                return false;
            }
        }
        else {
            echo "<br/> Incorrect frequency Value<br/>";
            return false;
        }

        return true;
    }

    function deleteFixumFromUser() {

        return true;
    }

    /** Creates new User after hashing the Password
     * @param $firstname
     * @param $lastname
     * @param $mail
     * @param $pass
     * @return bool
     */
    function createUser($firstname, $lastname, $mail, $pass) {

        $SQL = "INSERT INTO User (Firstname, Lastname, Mail, Password) 
                VALUES ('" . mysqli_real_escape_string($this->con, $firstname) . "','" . mysqli_real_escape_string($this->con, $lastname) . "', '" . mysqli_real_escape_string($this->con, $mail) . "', '" . password_hash($pass) . "');";

        if(!$this->getUserWithMail($mail)) {
            if(!mysqli_query($this->con, $SQL)){

                echo "Insert failed: " . mysqli_error($this->con);
                return false;
            }
        }
        else{

            echo "Mail ist already registered";
            return false;
        }

        return true;
    }

    function deleteUser() {

        return true;
    }

    function checkPassword($mail, $pass) {

        if($this->getUserWithMail($mail)) {

            $SQL = "SELECT Password FROM USER WHERE Mail = '" . mysqli_real_escape_string($this->con, $mail) . "'";

            $result = mysqli_query($this->con, $SQL, MYSQLI_STORE_RESULT)->fetch_array();

            echo "<br/>";
            var_dump($result['Password']);
            echo "<br/>";
            var_dump(password_hash($pass));

            if(password_hash($pass) == $result['Password']){

                return true;
            }
            else{

                return false;
            }
        }
    }

    function getUserWithMail($mail) {

        $SQL = "SELECT * FROM USER WHERE Mail = '" . mysqli_real_escape_string($this->con, $mail) . "'";

        $result = mysqli_query($this->con, $SQL,MYSQLI_STORE_RESULT)->fetch_array();
        return $result;
    }
}

$Repo = new Repository();

$Repo->init();

//$Repo->createUser('Der', 'Typ', 'DerTyp@Fakemail.de', 'pass');

if($Repo->checkPassword('DerTyp@Fakemail.de', 'pass')){

    echo "Success";
}
else{

    echo "no Success";
}