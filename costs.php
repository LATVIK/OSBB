<?php
include 'connect.php';
$status = mysqli_query($connection, "SELECT status_id FROM tenant WHERE tenant.id = {$_COOKIE['userId']}");
mysqli_close($connection);

$status = mysqli_fetch_assoc($status);
$status = $status['status_id'];

if(isset($_GET['category_id']) and isset($_GET['sum']) and isset($_GET['description']) and ($status=5)){
  $category_id = $_GET['category_id'];
  $sum = $_GET['sum'];
  $description = $_GET['description'];

  if(($category_id !="") and ($sum != "") and ($description != "")){
    include 'connect.php';
    echo "$sum  $description  ";
    $result = mysqli_query($connection, "INSERT INTO `costs` (`sum`, `category_id`, `description`) VALUES ('$sum', '$category_id', '$description' )");
    mysqli_close($connection);

    if(!$result){
      echo "Value not added";
      }else {
      echo "Value added";
      }
    }
  }


?>



<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Расходы</title>
  </head>

      <?php
      include 'navBar.php';
          ?>


  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-12 mx-auto">
        <h1 class="fw-light">
          <?php
          
include 'connect.php';
          
$sumPayment = mysqli_query($connection, "CALL sumPayment()");

$sumPayment = mysqli_fetch_assoc($sumPayment);
$sumPayment = $sumPayment['sum'];

mysqli_close($connection);
include 'connect.php';


$sumCosts = mysqli_query($connection, "CALL sumCosts()");

mysqli_close($connection);

$sumCosts = mysqli_fetch_assoc($sumCosts);
$sumCosts = $sumCosts['sum'];
$state      = $sumPayment - $sumCosts;
echo "Баланс: ";
echo ($state);


?>
 </h1>

      </div>
    </div>
  </section>

          
  <form method="get">
    <select name="category_id">
      <option selected value="">Все</option>
       <?php
                include 'connect.php';
                $category = mysqli_query($connection, "SELECT * FROM category");
            $category = mysqli_fetch_all($category);
            foreach ($category AS $cat) {
              
            ?>
            <option value="<?= $cat[0];?>"><?= $cat[1]; ?></option>
             <?php }?>
</select>
<br>
 <br>
<?php 
    if($status == 5){
      ?>
        <div class="mb-3">
    <label for="sum">Сумма</label>
    <input type="number" name="sum" step="0.01" id="sum" class="form-label"><br>
    <label for="description">Описание</label>
    <input type="text" id="description" name="description" class="form-label"><br>
  </div>
  <?php


  }

?>

<button class="btn btn-primary" type="submit">Подтвердить</button><br><br>
  





<?php




          if(isset($_GET['category_id'])){
            if($_GET['category_id'] != ""){
            $query = "SELECT * FROM costs WHERE category_id = {$_GET['category_id']} ORDER BY costs.date DESC";
            } else{
            $query = "SELECT * FROM costs ORDER BY costs.date DESC ";
              }
          } else{
            $query = "SELECT * FROM costs ORDER BY costs.date DESC";
          }


          $costs = mysqli_query($connection, $query);
        
          
          $costs = mysqli_fetch_all($costs, MYSQLI_ASSOC);
          foreach ($costs AS $cost):
          ?>

          <div class="p-4 mb-4 bg-light rounded-3">
            <div class="container-fluid">
            <h1 class="display-7 fw-bold"><?= $cost['sum'] ?></h1>

            <p class="col-md-12 fs-4"><?= $cost['description'] ?> </p>
    
      </div>
    </div> 
      <?php
endforeach;
?>
 
  </div>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

  </body>
</html>
