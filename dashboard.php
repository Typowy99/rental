<?php
session_start();
require('../functions.php');
if(!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true){
    die("Dostęp zabroniony!!!");
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>

  <div class="col-12">
    <h1 class="text-center font-weight-bold p-5">REZERWACJE</h1>
    <div class="text-center">
      <a href="../index.php" class="'m-2">POWRÓT</a> | <a href="logout.php" class="m-2">WYLOGUJ</a>
    </div>
  </div>
  <div class="container p-5">
    <div class="row">
      <table class="table table-dark table-striped">
        <thead>
        <?php

$rows = generate_dashboard();

for($i=0;$i<count($rows);$i++){
    echo '<tr>';
    echo '<th scope="row">'.($i+1).'</th>';
    echo '<td>'.$rows[$i]['name'].'</td>';
    echo '<td>'.$rows[$i]['surname'].'</td>';
    echo '<td>'.$rows[$i]['cost'].'</td>';
    echo '<td>'.$rows[$i]['to_date'].'</td>';
    echo '</tr>';
}
?> 

        </tbody>
      </table>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
    crossorigin="anonymous"></script>
</body>

</html>