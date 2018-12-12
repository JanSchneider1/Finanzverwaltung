<?php

require_once __dir__."/Repository.php";
require_once __dir__."/User.php";
require_once __dir__."/Accounting.php";
require_once __dir__."/Category.php";
require_once __dir__."/Fixum.php";

/**
 * Class ContentService
 * @author Albers
 */
class ContentService
{

    public $user;
    public $accountings;
    public $categories;
    public $fixa;
    public $repo;

    /**
     * ContentService constructor.
     * @param $mail
     */
    function __construct($mail) {
        $this->repo = new Repository();
        $this->repo->init();
        $tmp = $this->repo->getUserWithMail($mail);
        $this->user = new User($tmp['UserID'], $tmp['Firstname'], $tmp['Lastname'], $tmp['Mail']);
        $this->reloadAccountings($this->repo->getAccountingsByUser($this->user->getUserID()));
        $this->reloadFixa($this->repo->getFixaByUser($this->user->getUserID()));
        $this->reloadCategories($this->repo->getCategoriesByUser($this->user->getUserID()));
    }

    /** Reloads the accountings array with the output of a repo get function
     * @param $reloadFunction
     */
    function reloadAccountings($reloadFunction) {
        $this->accountings = array();
        for ($i = 0; $i < sizeof($reloadFunction); $i++) {
            $this->accountings[$i] = new Accounting($reloadFunction[$i]['AccountingID'], $reloadFunction[$i]['Value'], $reloadFunction[$i]['IsPositive'], $reloadFunction[$i]['Date'], $reloadFunction[$i]['Name'], $reloadFunction[$i]['CategoryID']);
        }
    }

    /** Reloads the fixa array with the output of a repo get function
     * @param $reloadFunction
     */
    function reloadFixa($reloadFunction){
        $this->fixa = array();
        for ($i = 0; $i < sizeof($reloadFunction); $i++) {
            $this->fixa[$i] = new Fixum($reloadFunction[$i]['FixumID'], $reloadFunction[$i]['Value'], $reloadFunction[$i]['IsPositive'], $reloadFunction[$i]['StartDate'], $reloadFunction[$i]['LastUsedDate'], $reloadFunction[$i]['Name'], $reloadFunction[$i]['Frequency'], $reloadFunction[$i]['CategoryID']);
        }
    }

    /** Reloads the categories array with the output of a repo get function
     * @param $reloadFunction
     */
    function reloadCategories($reloadFunction){
        $this->categories = array();
        for ($i = 0; $i < sizeof($reloadFunction); $i++) {
            $this->categories[$i] = new Category($reloadFunction[$i]['CategoryID'], $reloadFunction[$i]['Name']);
        }
    }

    /** Returns true if the timespan of a fixum has passed
     * @param $fixum
     * @return bool
     */
    function didFrequency($fixum)
    {

        $now = new DateTime();
        $lastDT = null;
        $bool = false;

        if ($fixum->getLastUsedDate() == null) {
            $lastDT = new DateTime($fixum->getStartDate());;
        } else {
            $lastDT = new DateTime($fixum->getLastUsedDate());
        }
        $diff = date_diff($lastDT, $now);

        switch ($fixum->getFrequency()) {
            case 'DAY':
                if ($diff->days > 0) {
                    $bool = true;
                }
                break;
            case 'WEEK':
                if ($diff->days >= 7) {
                    $bool = true;
                }
                break;
            case 'MONTH':
                if ($diff->m > 0) {
                    $bool = true;
                }
                break;
            case 'QUARTER':
                if ($diff->m >= 3) {
                    $bool = true;
                }
                break;
            case 'YEAR':
                if ($diff->y > 0) {
                    $bool = true;
                }
                break;
        }
        return $bool;
    }

    /**Generates accountings from all fixa
     *
     */
    function generateAccountingsFromFixa()
    {

        //wenn fixum da
        if ($this->fixa != null) {

            //für jedes fixum
            foreach ($this->fixa as $fixum) {

                $now = new DateTime();
                $start = new DateTime($fixum->getStartDate());
                $lastDT = null;
                $last = null;
                $numGenerate = 0;
                $datesGenerate = array();

                if ($fixum->getLastUsedDate() == null) {
                    $lastDT = $start;
                    $numGenerate++;
                    $datesGenerate[0] = $lastDT->format('y-m-d');
                } else {
                    $lastDT = new DateTime($fixum->getLastUsedDate());
                }
                //wenn startdatum in der Vergangenheit & Frequenz des fixums durchlaufen ist
                if (!date_diff($start, $now)->invert && $this->didFrequency($fixum)) {

                    //liste aus zu erzeugenden datum generiern
                    switch ($fixum->getFrequency()) {
                        case 'DAY':
                            $numGenerate += date_diff($lastDT, $now)->days;
                            for ($i = sizeof($datesGenerate); $i < $numGenerate; $i++) {
                                date_modify($lastDT, '+1 day');
                                $last = $datesGenerate[$i] = $lastDT->format('y-m-d');
                            }
                            break;
                        case 'WEEK':
                            $numGenerate += (int)(date_diff($lastDT, $now)->days / 7);
                            for ($i = sizeof($datesGenerate); $i < $numGenerate; $i++) {
                                date_modify($lastDT, '+1 week');
                                $last = $datesGenerate[$i] = $lastDT->format('y-m-d');
                            }
                            break;
                        case 'MONTH':
                            $numGenerate += (int)(date_diff($lastDT, $now)->m + date_diff($lastDT, $now)->y * 12);
                            for ($i = sizeof($datesGenerate); $i < $numGenerate; $i++) {
                                date_modify($lastDT, '+1 month');
                                $last = $datesGenerate[$i] = $lastDT->format('y-m-d');
                            }
                            break;
                        case 'QUARTER':
                            $numGenerate += (int)((date_diff($lastDT, $now)->m + date_diff($lastDT, $now)->y * 12) / 3);
                            for ($i = sizeof($datesGenerate); $i < $numGenerate; $i++) {
                                date_modify($lastDT, '+3 month');
                                $last = $datesGenerate[$i] = $lastDT->format('y-m-d');
                            }
                            break;
                        case 'YEAR':
                            $numGenerate += (int)date_diff($lastDT, $now)->y;
                            for ($i = sizeof($datesGenerate); $i < $numGenerate; $i++) {
                                date_modify($lastDT, '+1 year');
                                $last = $datesGenerate[$i] = $lastDT->format('y-m-d');
                            }
                            break;
                    }
                    //accounting für jedes datum erzeugen
                    if ($datesGenerate != null) {
                        foreach ($datesGenerate as $date) {
                            $this->repo->createAccountingForUser($this->user->getUserID(), $fixum->getName(), $fixum->getValue(), $fixum->getIsPositive(), $date, $fixum->getCategoryID());
                            $this->repo->relateFixumAccounting($this->repo->getLatestAccountingByUser($this->user->getUserID())['AccountingID'], $fixum->getFixumID());
                        }
                        $this->repo->alterFixumLastUsedDate($fixum->getFixumID(), $last);
                    }
                }
            }
        }
        $this->reloadAccountings();
    }

    function getIncomeFromAll() {

        $value = 0;
        foreach ($this->accountings as $a) {
            if ($a->getIsPositive() == 1) {
                $value += $a->getValue();
            }
        }
        return $value;
    }

    function getIncomeBetween($dateStart, $dateEnd) {

    }

    function getCostsFromAll() {

        $value = 0;
        foreach ($this->accountings as $a) {
            if ($a->getIsPositive() == 0) {
                $value += $a->getValue();
            }
        }
        return $value;
    }

    function getCostsBetween($dateStart, $dateEnd) {


    }

    function getBalanceFromAll() {

        $value = 0;
        foreach ($this->accountings as $a) {
            $value += $a->getValue();
        }
        return $value;
    }

    function getBalanceBetween($dateStart, $dateEnd) {


    }
}
/*$cs = new ContentService('derflo@mail.de');
//$cs->generateAccountingsFromFixa();
//$cs->reloadAccountings($cs->repo->getAccountingsByCategory(1, 5));
//$cs->reloadCategories($cs->repo->getCategoryByID(5));
foreach ($cs->categories as $a){
    echo $a->getName() . '</br>';
}
*/