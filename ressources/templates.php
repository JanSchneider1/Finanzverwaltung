<?php
/**
 * Created by PhpStorm.
 * User: albers
 * Date: 08.12.2018
 * Time: 13:22
 */

function setRedirect(){

    if ($_SESSION["userId"])
    {
        $user=$_SESSION["userId"];
    }
    else {
        header('Location: ../sites/login.php');
    }
}

function printFooter(){
    echo <<< Footer
            <div class="footer title" style="text-align: center;">
              <a href="impressum.php">Impressum</a><br/>
              <span style="color:#969696">&copy;Copyright 2019 Florian Albers, Cem Caylak, Jan Schneider, Niklas Firnges</span>
              <br/><br/>
            </div> 
Footer;
}

function printHeader(){
    $namespace = new Repository();
    $namespace->init();
    $user = $namespace->getUserWithMail($_SESSION["email"])["Firstname"]." ".$namespace->getUserWithMail($_SESSION["email"])["Lastname"];
    echo <<< Header
        <nav class="header navbar navbar-expand-sm">
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link hvr-underline-from-center" style="color: white" href="../sites/home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link hvr-underline-from-center" style="color: white; margin-left: 30px;" href="../sites/accountingList.php">Transaktionen</a>
              </li>
              <li>
              <a class="nav-link hvr-underline-from-center" style="color: white ;margin-left: 30px;" href="../sites/categoryList.php">Kategorien</a>
              </li>
              <li class="nav-item">
                <a class="nav-link hvr-underline-from-center" style="color: white ;margin-left: 30px;" href="../sites/fixumList.php">Daueraufträge</a>
              </li>
              <li class="nav-item">
                  <span class="dropdown" style="margin-left: 30px;" >
                    <span class="nav-link hvr-underline-from-center" value="Alle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Analyse</span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <li><a class="dropdown-item effect-underline" href="../sites/analyticBars.php">Balken</a></li>
                      <li><a class="dropdown-item effect-underline" href="../sites/analyticDoughnut.php">Kreis</a></li>
                      <li><a class="dropdown-item effect-underline" href="../sites/analyticCalendar.php">Kalender</a></li>
                      <li><a class="dropdown-item effect-underline" href="../sites/analyticGraph.php">Graph</a></li>
                    </ul>
                  </span>
              </li>
            </ul>
          </div>
          <ul class="nav navbar-nav navbar-right"> 
            <li>
                <a class="nav-link" href="../sites/changeEmail.php" style="margin-top: 10px;">Eingeloggt als<span style="color: lightskyblue;"> $user</span> <span class="fas fa-cog" style="color: dodgerblue;"></span></a>
            </li>
            <li>
                <a class="nav-link" href="../ressources/logout.php"><button class="nav-link btn btn-dark hvr-shutter-out-horizontal" style="color: white">Ausloggen</button></a>
            </li>
          </ul>
        </nav>
Header;
}