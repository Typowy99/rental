<?php 
require('functions.php');
?>
<!doctype html>
<!doctype html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wypozyczalnia motocykli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d5364f429b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-black">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <i class="fa-solid fa-motorcycle"></i>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" onclick="smoothScroll('#unavilable')">DOSTĘPNE MOTOCYKLE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="smoothScroll('#reservation')">ZAREZERWUJ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="container2">
                <h1 class="title">WYPOŻYCZALNIA MOTOCYKLI</h1>
                <div class="buttons">
                    <button class="btn1" onclick="smoothScroll('#unavilable')">OFERTA</button>
                    <button class="btn1" onclick="smoothScroll('#reservation')">REZERWUJ</button>
                </div>
            </div>
        </div>
    </header>

    <section id="unavilable">
        <div class="container-fluid p-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center p-5">DOSTĘPNE MOTOCYKLE</h1>
                </div>
            </div>
            <div class="row">
                
                <?php
          $rows = get_motocykl('avalible');
          
          foreach($rows as $r) {
            echo '<div class="col-lg-3 col-md-6 col-sm-12 mt-3">';
            echo '<div class="motocykld">';
            echo '<img src="assets/'.$r['photo_url'].'" class="motocykld-img-top" alt="motocykl">';
            echo '<div class="motocykld-body">';
            echo '<h5 class="motocykld-title text-center">'.$r['name'].'</h5>';
            echo '<p class="text-center">'.$r['type'].'</p>';
            echo  '<p class="text-center font-weight-bold">'.$r['price'].' zł / h</p>';
            echo '<button class="btn btn-primary col-12" onclick="reserve('.$r['id'].');calculate_price('.$r['price'].');">REZERWUJ</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        ?>
            </div>
        </div>
    </section>


    <section id="reservation">
        <div class="container-fluid">
            <h1 class="text-center font-weight-bold p-5">ZAREZERWUJ</h1>
            <div class="row">
                <div class="col-12 text-center text-danger">
                    <h2><span id="amount">0</span> zł</h2>
                </div>
                <div class="col-12 d-flex justify-content-center p-5 text-white">
                    <form action="reserve.php" method="POST">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Imię</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Podaj imię" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="surname">Nazwisko</label>
                                    <input type="text" class="form-control" name="surname" id="surname"
                                        placeholder="Podaj nazwisko" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefon</label>
                            <input type="tel" name="phone" class="form-control" placeholder="Podaj numer telefonu"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="motocykl">Samochód</label>
                            <select name="motocykl" class="form-control" id="motocykl">
                                <?php
                      $rows = get_motocykl("select");
    
                      foreach($rows as $r) {
                        echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
                      }
                    ?>

                            </select>

                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="date">Termin</label>
                                    <input type="datetime-local" class="form-control" name="date" id="date" required>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="days">Dni</label>
                                            <input type="number" class="form-control" name="days" id="days" min="0"
                                                max="13">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="hours">Godzin</label>
                                            <input type="number" class="form-control" name="hours" id="hours" min="0"
                                                max="23">
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <input type="submit" value="REZERWUJ" class="btn btn-danger col-12">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>

</html>