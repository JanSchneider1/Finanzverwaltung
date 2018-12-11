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
    echo <<< Header
        <nav class="navbar navbar-expand-sm bg-dark">
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Buchungen</a>
              </li>
              <a class="nav-link" href="/categories.php">Kategorien</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Fixa</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Analyse</a>
              </li>
            </ul>
          </div>
          <ul class="nav navbar-nav navbar-right">
            <a class="nav-link" href="#"><span class="navbar-text" style="color: white">Eingeloggt als: Jan Schneider</span></a>
            <a class="nav-link" href="#">
              <button class="nav-link bg-dark btn btn-primary" style="color: white">Ausloggen</button>
            </a>
          </ul>
        </nav>
        </div>
Header;
}

