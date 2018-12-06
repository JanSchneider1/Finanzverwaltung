<?php
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
      <button class="nav-link bg-dark" style="color: white">Ausloggen</button>
    </a>
  </ul>
</nav>
</div>
Header;
?>
