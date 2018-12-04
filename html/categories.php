<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
</head>
<body>

<?php

include __DIR__ . "/../Php files/ContentService.php";

$service = new ContentService('derflo@mail.de');
//var_dump($service->categories);
foreach ($service->categories as $c){
    echo '<p>'.$c->getName().'</p>';
}

?>

</body>
</html>