<?php


/**
 * Created by PhpStorm.
 * User: albers
 * Date: 08.12.2018
 * Time: 13:22
 */

function printFooter(){

    echo <<< Footer
            <div class="background title" style="text-align: center;">
              <a href="#">Impressum</a><br/>
              <span style="color:#969696">&copy;Copyright 2018 Florian Albers, Cem Caylak, Jan Schneider, Niklas Firnges</span>
            </div> 
Footer;
}

function printHeader()
{
    $user=$_SESSION["userId"];
    echo <<< Header
        <nav class="navbar navbar-expand-sm bg-dark">
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link hvr-underline-from-center" style="color: white" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link hvr-underline-from-center" style="color: white; margin-left: 30px;" href="#">Buchungen</a>
              </li>
              <a class="nav-link hvr-underline-from-center" style="color: white ;margin-left: 30px;" href="/categories.php">Kategorien</a>
              </li>
              <li class="nav-item">
                <a class="nav-link hvr-underline-from-center" style="color: white ;margin-left: 30px;" href="#">Fixa</a>
              </li>
              <li class="nav-item">
                <a class="nav-link hvr-underline-from-center" style="color: white ;margin-left: 30px;" href="#">Analyse</a>
              </li>
            </ul>
          </div>
          <ul class="nav navbar-nav navbar-right">
            <a class="nav-link" href="#"><span class="navbar-text" style="color: white">
            <?php
                echo "Eingeloggt als".$user;
                ?>
                </span></a>
            <a class="nav-link" href="#">
              <button class="nav-link btn btn-dark hvr-shutter-out-horizontal" style="color: white">Ausloggen</button>
            </a>
          </ul>
        </nav>
        </div>
Header;
}

?>