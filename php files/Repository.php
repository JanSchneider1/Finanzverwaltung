<?php

/**
 * Class Repository
 * Object for accessing the Database
 *
 * User Input is cleaned up with mysqli_real_escape_string
 * @author Albers
 */
class Repository
{

    /**
     * @var string
     */
    private $pass = "";
    private $user = "root";
    private $db = "accounting";
    private $host = "localhost";
    private $con;

    /**
     * Initialising of the DB Connection
     * Returns true on success, false on failure
     * @return bool
     */
    function init() {

        $this->con = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->con->connect_error) {
            die("DB Connection failed: " . $this->con->connect_error);
            return false;
        }

        return true;
    }

    /**Returns an array that contains accounting data arrays
     * @param $userID
     * @return mixed
     */
    function getAllAccountingsByUser($userID) {

        $SQL = "SELECT * FROM Accounting WHERE UserID = '" . $userID . "'";

        $result = mysqli_query($this->con, $SQL)->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    /** Returns an array that contains accounting data arrays
     *  only returns accountings between start and end date
     * @param $userID
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    function getAllAccountingsByUserBetweenDates($userID, $startDate, $endDate) {

        $SQL = "SELECT * FROM Accounting WHERE UserID = " . $userID . " AND Date BETWEEN '" . $startDate . "' AND '" . $endDate . "';";

        $result = mysqli_query($this->con, $SQL)->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    /** Creates a new Accounting
     * Returns true on success, false on failure
     * @param $userID
     * @param $name
     * @param $value
     * @param $isPositive
     * @param $date
     * @param $categoryID
     * @return bool
     */
    function createAccountingForUser($userID, $name, $value, $isPositive, $date, $categoryID) {

        $SQL = "INSERT INTO Accounting (Value, IsPositive, Date, Name, UserID, CategoryID) 
                VALUES (" . $value . ", " . $isPositive . ", " . $date . ", '" . mysqli_real_escape_string($this->con, $name) . "', " . $userID . ", " . $categoryID . ");";
        echo $SQL . "<br7>";

        if (!mysqli_query($this->con, $SQL)) {

            echo "Insert failed: " . mysqli_error($this->con);
            return false;
        }

        return true;
    }

    /**Deletes an Accounting
     * Returns true on success, false on failure
     * @param $accountingID
     * @return bool
     */
    function deleteAccounting($accountingID) {

        $SQL = "DELETE FROM Accounting WHERE AccountingID = '" . $accountingID . "'";

        if (!mysqli_query($this->con, $SQL)) {

            return false;
        }

        return true;
    }

    /** Returns an array that contains category data arrays
     * @param $userID
     * @return mixed
     */
    function getAllCategoriesByUser($userID) {

        $SQL = "SELECT * FROM Category WHERE UserID ='" . $userID . "';";

        $result = mysqli_query($this->con, $SQL)->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    /**Creates a new category for an user
     * Returns true on success, false on failure
     * @param $userID
     * @param $categoryName
     * @return bool
     */
    function createCategoryForUser($userID, $categoryName) {

        $SQL = "INSERT INTO Category (Name, UserID) 
                VALUES ('" . mysqli_real_escape_string($this->con, $categoryName) . "', " . $userID . ");";

        if (!mysqli_query($this->con, $SQL)) {

            echo "Insert failed: " . mysqli_error($this->con);
            return false;
        }

        return true;
    }

    /** Alter the name of a category
     * Returns true on success, false on failure
     * @param $categoryID
     * @param $Name
     * @return bool
     */
    function alterCategoryName($categoryID, $Name){

        $SQL = "UPDATE Category SET Name = '" . mysqli_real_escape_string($this->con, $Name) . "' WHERE CategoryID = " . $categoryID . ";";

        if(!mysqli_query($this->con, $SQL)) {

            mysqli_error($this->con);
            return false;
        }

        return true;
    }

    /** Deletes a category
     * Returns true on success, false on failure
     * @param $categoryID
     * @return bool
     */
    function deleteCategory($categoryID) {

        $SQL = "DELETE FROM Category WHERE CategoryID = '" . $categoryID . "'";

        if (!mysqli_query($this->con, $SQL)) {

            return false;
        }

        return true;
    }

    /** Returns an array that contains fixum data arrays
     * @param $userID
     * @return mixed
     */
    function getAllFixaByUser($userID) {

        $SQL = "SELECT * FROM Fixum WHERE UserID = '" . $userID . "'";

        $result = mysqli_query($this->con, $SQL)->fetch_all(MYSQLI_ASSOC);
        return result;
    }

    /** Creates a new fixum for an user
     * Returns true on success, false on failure
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

        if ($frequency == "DAY" || $frequency == "WEEK" || $frequency == "MONTH" || $frequency == "QUARTER" || $frequency == "YEAR") {

            $SQL = "INSERT INTO Fixum (Value, IsPositive, StartDate, Name, Frequency, UserID, CategoryID) 
                    VALUES (" . $value . ", " . $isPositive . ", " . $startDate . ", '" . mysqli_real_escape_string($this->con, $name) . "','" . mysqli_real_escape_string($this->con, $frequency) . "'," . $userID . ", " . $categoryID . ");";

            if (!mysqli_query($this->con, $SQL)) {

                echo "Insert failed: " . mysqli_error($this->con);
                return false;
            }
        } else {
            echo "<br/> Incorrect frequency Value<br/>";
            return false;
        }

        return true;
    }

    /**Deletes a fixum
     * Returns true on success, false on failure
     * @param $fixumID
     * @return bool
     */
    function deleteFixum($fixumID) {

        $SQL = "DELETE FROM Accounting WHERE FixumID = '" . $fixumID . "'";

        if (!mysqli_query($this->con, $SQL)) {

            return false;
        }

        return true;
    }

    /** Changes the startdate of a fixum
     * Returns true on success, false on failure
     * @param $fixumID
     * @param $startDate
     * @return bool
     */
    function alterFixumStartDate($fixumID, $startDate){

        $SQL = "UPDATE Fixum SET StartDate = '" . $startDate . "' WHERE FixumID = " . $fixumID . ";";

        if (!mysqli_query($this->con, $SQL)) {

            echo mysqli_error($this->con);
            return false;
        }

        return true;
    }

    /** Changes the value of a fixum
     * Returns true on success, false on failure
     * @param $fixumID
     * @param $value
     * @return bool
     */
    function alterFixumValue($fixumID, $value) {

        $SQL = "UPDATE Fixum SET Value = " . $value . " WHERE FixumID = " . $fixumID . ";";

        if (!mysqli_query($this->con, $SQL)) {

            echo mysqli_error($this->con);
            return false;
        }

        return true;
    }

    /** Changes the name of a fixum
     * Returns true on success, false on failure
     * @param $fixumID
     * @param $name
     * @return bool
     */
    function alterFixumName($fixumID, $name) {

        $SQL = "UPDATE Fixum SET Name = '" . mysqli_real_escape_string($this->con, $name) . "' WHERE FixumID = " . $fixumID . ";";

        if (!mysqli_query($this->con, $SQL)) {

            echo mysqli_error($this->con);
            return false;
        }

        return true;
    }

    /** Creates new user
     * Auto hashes password
     * Returns true on success, false on failure
     * @param $firstname
     * @param $lastname
     * @param $mail
     * @param $pass
     * @return bool
     */
    function createUser($firstname, $lastname, $mail, $pass) {

        $SQL = "INSERT INTO User (Firstname, Lastname, Mail, Password) 
                VALUES ('" . mysqli_real_escape_string($this->con, $firstname) . "','" . mysqli_real_escape_string($this->con, $lastname) . "', '" . mysqli_real_escape_string($this->con, $mail) . "', '" . password_hash($pass, PASSWORD_DEFAULT) . "');";

        if (!$this->getUserWithMail($mail)) {
            if (!mysqli_query($this->con, $SQL)) {

                echo "Insert failed: " . mysqli_error($this->con);
                return false;
            }
        } else {

            echo "Mail ist already registered";
            return false;
        }

        return true;
    }

    /** Deletes an user
     * Returns true on success, false on failure
     * @param $userID
     * @return bool
     */
    function deleteUser($userID) {

        $SQL = "DELETE FROM User WHERE UserID = '" . $userID . "'";

        if (!mysqli_query($this->con, $SQL)) {

            return false;
        }

        return true;
    }

    /**Checks if the password assigned to the mail is correct.
     * Returns true if password is matching, else false
     * Auto checks if user exists
     * @param $mail
     * @param $pass
     * @return bool
     */
    function checkPassword($mail, $pass) {

        if ($this->getUserWithMail($mail)) {

            $SQL = "SELECT Password FROM USER WHERE Mail = '" . mysqli_real_escape_string($this->con, $mail) . "'";

            $result = mysqli_query($this->con, $SQL)->fetch_array();

            if (password_verify($pass, $result['Password'])) {

                return true;
            }
            else {

                return false;
            }
        }
        else {

            echo "<br/>User not found";
            return false;
        }
    }

    /**Returns an array with user data if user Exits
     * Else returns null
     * @param $mail
     * @return mixed
     */
    function getUserWithMail($mail) {

        $SQL = "SELECT * FROM USER WHERE Mail = '" . mysqli_real_escape_string($this->con, $mail) . "'";

        $result = mysqli_query($this->con, $SQL)->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
}

//Tests
$Repo = new Repository();
$Repo->init();