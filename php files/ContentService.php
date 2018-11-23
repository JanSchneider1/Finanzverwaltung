<?php

require_once __dir__."/Repository.php";
require_once __dir__."/User.php";
require_once __dir__."/Accounting.php";
require_once __dir__."/Category.php";
require_once __dir__."/Fixum.php";

class ContentService {

    public $user;
    public $accountings;
    public $categories;
    public $fixa;
    private $repo;

    function  __construct($mail) {
        $this->repo = new Repository();
        $this->repo->init();
        $tmp = $this->repo->getUserWithMail($mail);
        $this->user = new User($tmp['UserID'], $tmp['Firstname'], $tmp['Lastname'], $tmp['Mail']);
        $tmp = $this->repo->getAccountingsByUser($this->user->getUserID());
        for($i = 0; $i < sizeof($tmp); $i ++) {
            $this->accountings[$i] = new Accounting($tmp[$i]['AccountingID'], $tmp[$i]['Value'], $tmp[$i]['IsPositive'], $tmp[$i]['Date'], $tmp[$i]['Name'], $tmp[$i]['CategoryID']);
        }
        $tmp = $this->repo->getFixaByUser($this->user->getUserID());
        for($i = 0; $i < sizeof($tmp); $i ++) {
            $this->fixa[$i] = new Fixum($tmp[$i]['FixumID'], $tmp[$i]['Value'], $tmp[$i]['IsPositive'], $tmp[$i]['StartDate'], $tmp[$i]['LastUsedDate'], $tmp[$i]['Name'], $tmp[$i]['Frequency'], $tmp[$i]['CategoryID']);
        }
        $tmp = $this->repo->getCategoriesByUser($this->user->getUserID());
        for($i = 0; $i < sizeof($tmp); $i ++) {
            $this->categories[$i] = new Category($tmp[$i]['CategoryID'], $tmp[$i]['Name']);
        }
    }

    function generateAccountingsFromFixa() {

        foreach ($this->fixa as $fixum) {
            if($fixum['StartDate']){ continue;} /////////wenn startdatum in der zukunft

            $lastDate = null;
            if($fixum['LastUsedDate'] == null) {
                $lastDate = $fixum['StartDate'];
            } else {
                $lastDate = $fixum['LastUsedDate'];
            }

            switch($fixum['Frequency']) {    //Anzahl der accountings herausfinden
                case 'DAY':
                    break;
                case 'WEEK':
                    break;
                case 'MONTH':
                    break;
                case 'QUARTER':
                    break;
                case 'YEAR':
                    break;
            }
        }
    }

}
/*
$cs = new ContentService('derflo@mail.de');
echo '<pre>';
var_dump($cs->accountings);
echo '<br/>';
echo '<pre>';
var_dump($cs->fixa);
echo '<br/>';
echo '<pre>';
var_dump($cs->user);
echo '<br/>';
echo '<pre>';
var_dump($cs->categories);
echo '<br/>';
*/