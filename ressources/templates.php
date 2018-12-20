<?php
/**
 * Created by PhpStorm.
 * User: albers
 * Date: 08.12.2018
 * Time: 13:22
 */

function printFooter(){
    echo <<< Footer
            <div class="footer title" style="text-align: center;">
              <a href="#">Impressum</a><br/>
              <span style="color:#969696">&copy;Copyright 2018 Florian Albers, Cem Caylak, Jan Schneider, Niklas Firnges</span>
              <br/><br/>
            </div> 
Footer;
}

function printHeader(){
    session_start();
    if ($_SESSION["userId"])
    {
        $user=$_SESSION["userId"];
    }
    else {
        echo "<script type='text/javascript'>location.href = 'login.php'</script>";
    }
    echo <<< Header
        <nav class="header navbar navbar-expand-sm">
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link hvr-underline-from-center" style="color: white" href="../sites/home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link hvr-underline-from-center" style="color: white; margin-left: 30px;" href="../sites/accountingList.php">Buchungen</a>
              </li>
              <a class="nav-link hvr-underline-from-center" style="color: white ;margin-left: 30px;" href="../sites/categoryList.php">Kategorien</a>
              </li>
              <li class="nav-item">
                <a class="nav-link hvr-underline-from-center" style="color: white ;margin-left: 30px;" href="../sites/fixumList.php">Fixa</a>
              </li>
              <li class="nav-item">
                  <div class="dropdown btn" style="margin-left: 30px;" >
                    <button class="hvr-grow btn" type="button" value="Alle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Analyse</button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <li><a class="dropdown-item effect-underline" href="../sites/analyticBars.php">Balken</a></li>
                      <li><a class="dropdown-item effect-underline" href="../sites/analyticDoughnut.php">Kreis</a></li>
                      <li><a class="dropdown-item effect-underline">Kalender</a></li>
                      <li><a class="dropdown-item effect-underline">Graph</a></li>
                    </ul>
                  </div>
              </li>
            </ul>
          </div>
          <ul class="nav navbar-nav navbar-right">
            <li>
                <span class="navbar-text" style="color: white">Eingeloggt als:</span>
            </li>   
            <li>
                <a class="nav-link" href="#"><span>$user</span> <span class="fas fa-cog"></span></a>
            </li>
            <li>
                <a class="nav-link" href="#"><button class="nav-link btn btn-dark hvr-shutter-out-horizontal" style="color: white">Ausloggen</button></a>
            </li>
          </ul>
        </nav>
        </div>
Header;
}