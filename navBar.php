<?php



if($_COOKIE['userId'] == ''){
  header('Location: ../OSMD/signin.php');
} 


?>
<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
  
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/jumbotron/">
<meta name="theme-color" content="#7952b3">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style> 
  </head>
  <body>
<main>
  <div class="container">
    <div class="col align-self-center">
        <form action="signout.php">
            <button> Выйти</button>
        </form>
    </div>
</div>
  <div class="container py-4">
    <header class="pb-3 mb-4 border-bottom">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
      <span class="fs-4">ОСМД "Дружба"</span>
    
    
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav me-auto mb-1 mb-lg-0">
      </ul>
      <ul class="navbar-nav ">
        <li class="nav-item">
              <a class="nav-link" href="index.php"><h4>Главная</h4></a>
            </li>
        <li class="nav-item">
              <a class="nav-link" href="contact.php"><h4>Контакты</h4></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="costs.php"><h4>Расходы</h4></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="personalArea.php"><h4>Кабинет</h4></a>
            </li>
      
      </ul>
    </div>
  </div>
</nav>

    </header>