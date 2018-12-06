<?php

/**
 * Class Repository
 * Object for accessing the Database
 *
 * SQL injections should not be possible due to prepared statements
 * Please remind that isPositive has to be handled as an int [1/0]
 * @author Albers
 */
class Repository {

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
            die("DB connection failed: " . $this->con->connect_error);
            return false;
        }
        return true;
    }

    function getCategoryByID($categoryID){

        $stmt = mysqli_prepare($this->con, "SELECT * FROM Category WHERE CategoryID = ?");
        $stmt->bind_param("i", $categoryID);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**Returns an array that contains accounting data arrays
     * @param $userID
     * @return mixed
     */
    function getAccountingsByUser($userID) {

        $stmt = mysqli_prepare($this->con, "SELECT * FROM Accounting WHERE UserID = ?;");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Returns an array that contains accounting data arrays
     *  only returns accountings between start and end date
     * @param $userID
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    function getAccountingsByUserBetweenDates($userID, $startDate, $endDate) {

        $stmt = mysqli_prepare($this->con,"SELECT * FROM Accounting WHERE UserID = ? AND Date BETWEEN ? AND ? ;");
        $stmt->bind_param("iss", $userID, $startDate, $endDate);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Returns an array that contains accounting data of the latest Accounting a user has
     * @param $userID
     * @return mixed
     */
    function getLatestAccountingByUser($userID) {

        $stmt = mysqli_prepare($this->con, "SELECT * FROM Accounting WHERE UserID = ? AND AccountingID = ( SELECT MAX(AccountingID) FROM Accounting);");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        return $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
    }

    /** Returns an array that contains accounting data arrays
     * @param $categoryID
     * @return mixed
     */
    function getAccountingsByCategory($categoryID) {

        $stmt = mysqli_prepare($this->con, "SELECT * FROM Accounting WHERE CategoryID = ?;");
        $stmt->bind_param("i", $categoryID);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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

        $stmt = mysqli_prepare($this->con, "INSERT INTO Accounting (Value, isPositive, Date, Name, UserID, CategoryID) VALUES(?,?,?,?,?,?);");
        $stmt->bind_param("dissii", $value, $isPositive, $date, $name, $userID, $categoryID);
        if (!$stmt->execute()) {

            echo "Insert failed: " . mysqli_error($this->con);
            return false;
        }
        return true;
    }

    /**Deletes an Accounting
     * @param $accountingID
     */
    function deleteAccounting($accountingID) {

        $stmt = mysqli_prepare($this->con, "DELETE FROM Accounting WHERE AccountingID = ?;");
        $stmt->bind_param("i", $accountingID);
        $stmt->execute();
    }


    /** Changes the date of an accounting
     * @param $accountingID
     * @param $date
     */
    function alterAccountingDate($accountingID, $date) {

        $stmt = mysqli_prepare($this->con, "UPDATE Accounting SET Date = ? WHERE AccountingID = ?");
        $stmt->bind_param("si", $date, $accountingID);
        $stmt->execute();
    }

    /** Changes the value of an accounting
     * @param $accountingID
     * @param $value
     */
    function alterAccountingValue($accountingID, $value) {

        $stmt = mysqli_prepare($this->con, "UPDATE Accounting SET Value = ? WHERE AccountingID = ?");
        $stmt->bind_param("di", $value, $accountingID);
        $stmt->execute();
    }

    /** Change the name of an accounting
     * @param $accountingID
     * @param $name
     */
    function alterAccountingName($accountingID, $name) {

        $stmt = mysqli_prepare($this->con, "UPDATE Accounting SET Name = ? WHERE AccountingID = ?;");
        $stmt->bind_param("si", $name, $accountingID);
        $stmt->execute();
    }

    /** Returns an array that contains category data arrays
     * @param $userID
     * @return mixed
     */
    function getCategoriesByUser($userID) {

        $stmt = mysqli_prepare($this->con, "SELECT * FROM Category WHERE UserID = ?;");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**Creates a new category for an user
     * @param $userID
     * @param $categoryName
     */
    function createCategoryForUser($userID, $categoryName) {

        $stmt = mysqli_prepare($this->con, "INSERT INTO Category (Name, UserID) VALUES (?,?);");
        $stmt->bind_param("si", $categoryName, $userID);
        $stmt->execute();
    }

    /** Alter the name of a category
     * @param $categoryID
     * @param $name
     */
    function alterCategoryName($categoryID, $name) {

        $stmt = mysqli_prepare($this->con, "UPDATE Category SET Name = ? WHERE CategoryID = ?;");
        $stmt->bind_param("si", $name, $categoryID);
        $stmt->execute();
    }

    /** Deletes a category
     * @param $categoryID
     */
    function deleteCategory($categoryID) {

        $stmt = mysqli_prepare($this->con, "DELETE FROM Category WHERE CategoryID = ?");
        $stmt->bind_param("i", $categoryID);
        $stmt->execute();
    }

    /** Returns an array that contains fixum data arrays
     * @param $userID
     * @return mixed
     */
    function getFixaByUser($userID) {

        $stmt = mysqli_prepare($this->con, "SELECT * FROM Fixum WHERE UserID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Creates a new fixum for an user
     * Returns false if frequency value is incorrect
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

            $stmt = mysqli_prepare($this->con, "INSERT INTO Fixum (Value, IsPositive, StartDate, Name, Frequency, UserID, CategoryID) VALUES (?,?,?,?,?,?,?);");
            $stmt->bind_param("disssii", $value, $isPositive, $startDate, $name, $frequency, $userID, $categoryID);
            $stmt->execute();
        } else {

            return false;
        }
        return true;
    }

    /** Deletes a fixum
     * @param $fixumID
     */
    function deleteFixum($fixumID) {

        $stmt = mysqli_prepare($this->con, "DELETE FROM Fixum WHERE FixumID = ?;");
        $stmt->bind_param("i", $fixumID);
        $stmt->execute();
    }

    /** Changes the startdate of a fixum
     * @param $fixumID
     * @param $startDate
     */
    function alterFixumStartDate($fixumID, $startDate) {

        $stmt = mysqli_prepare($this->con, "UPDATE Fixum SET StartDate = ? WHERE FixumID = ?;");
        $stmt->bind_param("si", $startDate, $fixumID);
        $stmt->execute();
    }

    /** Changes the LastUsedDate of a fixum
     * @param $fixumID
     * @param $lastUsedDate
     */
    function alterFixumLastUsedDate($fixumID, $lastUsedDate) {

        $stmt = mysqli_prepare($this->con, "UPDATE Fixum SET LastUsedDate = ? WHERE FixumID = ?;");
        $stmt->bind_param("si", $lastUsedDate, $fixumID);
        $stmt->execute();
    }

    /** Changes the value of a fixum
     * @param $fixumID
     * @param $value
     */
    function alterFixumValue($fixumID, $value) {

        $stmt = mysqli_prepare($this->con, "UPDATE Fixum SET Value = ? WHERE FixumID = ?;");
        $stmt->bind_param("si", $value, $fixumID);
        $stmt->execute();
    }

    /** Changes the name of a fixum
     * @param $fixumID
     * @param $name
     */
    function alterFixumName($fixumID, $name) {

        $stmt = mysqli_prepare($this->con, "UPDATE Fixum SET Name = ? WHERE FixumID = ?;");
        $stmt->bind_param("si", $name, $fixumID);
        $stmt->execute();
    }

    /** Creates new user
     * Auto hashes password
     * Returns true on success, false if user with mail already exists
     * @param $firstname
     * @param $lastname
     * @param $mail
     * @param $pass
     * @return bool
     */
    function createUser($firstname, $lastname, $mail, $pass) {

        $stmt = mysqli_prepare($this->con, "SELECT COUNT(Mail) FROM USER WHERE Mail = ?");
        $ml = mb_strtolower($mail);
        $stmt->bind_param("s", $ml);
        $stmt->execute();
        if (!($stmt->get_result()->fetch_all(MYSQLI_NUM)[0][0] > 0)) {

            $stmt = mysqli_prepare($this->con, "INSERT INTO User (Firstname, Lastname, Mail, Password) VALUES (?,?,?,?);");
            $password = password_hash($pass, PASSWORD_DEFAULT);
            $stmt->bind_param("ssss", $firstname, $lastname, $ml, $password);
            $stmt->execute();
        } else {
            return false;
        }
        return true;
    }

    /** Deletes an user
     * @param $userID
     */
    function deleteUser($userID) {

        $stmt = mysqli_prepare($this->con, "DELETE FROM User WHERE UserID = ?;");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
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
            $stmt = mysqli_prepare($this->con, "SELECT Password FROM USER WHERE Mail = ?;");
            $stmt->bind_param("s", $mail);
            $stmt->execute();

            $hash = $stmt->get_result()->fetch_array(MYSQLI_ASSOC)['Password'];
            if (!password_verify($pass, $hash)) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**Returns an array with user data if user Exits
     * Else returns null
     * @param $mail
     * @return mixed
     */
    function getUserWithMail($mail) {

        $ml = mb_strtolower($mail);
        $stmt = mysqli_prepare($this->con, "SELECT * FROM User WHERE Mail = ?;");
        $stmt->bind_param("s", $ml);
        $stmt->execute();
        return $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
    }

    /** Changes the password for an user
     * @param $userID
     * @param $pass
     */
    function alterUserPassword($userID, $pass) {

        $password = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($this->con, "UPDATE User SET Password = ? WHERE UserID = ?;");
        $stmt->bind_param("si", $password, $userID);
        $stmt->execute();
    }

    /** Changes the Mail of an user
     * @param $userID
     * @param $mail
     */
    function alterUserMail($userID, $mail) {

        $ml = mb_strtolower($mail);
        $stmt = mysqli_prepare($this->con, "UPDATE User SET Mail = ? WHERE UseriD = ?;");
        $stmt->bind_param("si", $ml, $userID);
        $stmt->execute();
    }

    /** Insertes a relation dataset into matching table
     * @param $accountingID
     * @param $fixumID
     */
    function relateFixumAccounting ($accountingID, $fixumID) {

        $stmt = mysqli_prepare($this->con, "INSERT INTO Accounting_Fixum VALUES (?,?);");
        $stmt->bind_param("ii", $accountingID, $fixumID);
        $stmt->execute();
    }
}

//-----------Tests----------------
//$Repo = new Repository();
//$Repo->init();

//var_dump($Repo->getAccountingsByUser(1));
//var_dump($Repo->getAccountingsByUserBetweenDates(1, '2018-11-11', '2018-11-18'));
//var_dump($Repo->getAccountingsByCategory(4));
//var_dump($Repo->getLatestAccountingByUser(1));
//$Repo->createAccountingForUser(1, 'Shampoo', 3.5, 0, '2018-11-19', 3);
//$Repo->alterAccountingDate(5, '2018-11-20');
//$Repo->deleteAccounting(5);
//$Repo->alterAccountingValue(5, 5.5);
//$Repo->alterAccountingName(5, 'Backfisch');
//var_dump($Repo->getCategoriesByUser(1));
//$Repo->createCategoryForUser(1, 'Pflege');
//$Repo->alterCategoryName(7, 'Medikamente');
//$Repo->deleteCategory(7);
//var_dump($Repo->getFixaByUser(1));
//var_dump($Repo->createFixumForUser(1, "Taschengeld", 150, 1, '2018-11-20', 'MONTH', 1));
//$Repo->deleteFixum(2);
//$Repo->alterFixumStartDate(1, '2018-12-6');
//$Repo->alterFixumLastUsedDate(1, '2018-12-06');
//$Repo->alterFixumValue(1, 50);
//$Repo->alterFixumName(1, 'Spielo');
//var_dump($Repo->getUserWithMail('derFlo@mail.de'));
//var_dump($Repo->checkPassword("derflo@mail.de", 'pass'));
//var_dump($Repo->createUser('Der', 'Typ', 'DerFo@mail.de', 'pass'));
//$Repo->deleteUser(1);
//$Repo->alterUserPassword(1, 'pass');
//$Repo->alterUserMail(1, 'derFlo@mail.de');
//$Repo->relateFixumAccounting(1, 1);