<?php
include 'navBar.php';
include 'connect.php';
$user_id = $_COOKIE['userId'];

$flat_id = mysqli_query($connection, "SELECT flat_id, status_id FROM tenant WHERE id= {$user_id}");
$flat_id = mysqli_fetch_assoc($flat_id);
$status = $flat_id['status_id'];

$flat_id = $flat_id['flat_id'];


?>

<?php 
    if($status == 5){
      ?>

<form action="insertPayment.php" method="post">
    <select required="true" name="flat_id">
      <option selected value="">Все</option>
       <?php
                include 'connect.php';
                $flats = mysqli_query($connection, "SELECT id FROM flat");
            $flats = mysqli_fetch_all($flats);
            foreach ($flats AS $flat) {
              
            ?>
            <option><?= $flat[0]; ?></option>
             <?php }?>
</select>
<br>
 <br>

        <div class="mb-3">
    <label for="sum">Сумма</label>
    <input required="true"  type="number" name="sum" step="0.01" id="sum" class="form-label"><br>
  </div>
  
<button class="btn btn-primary" type="submit">Confirm</button><br><br>
  
</form>

<?php


  }

?>










<html lang="ru"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Кабинет</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

<link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
 
  </head>
  <body>
  
<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-12 mx-auto">
        <h1 class="fw-light">
          <?php
$sumPayment = mysqli_query($connection, "CALL sumPaymentForFlat({$flat_id})");

$sumPayment = mysqli_fetch_assoc($sumPayment);
$sumPayment = $sumPayment['sum'];

mysqli_close($connection);
include 'connect.php';


$sumAccrual = mysqli_query($connection, "CALL sumAccrualForFlat({$flat_id})");

$sumAccrual = mysqli_fetch_assoc($sumAccrual);
$sumAccrual = $sumAccrual['sum'];
$state      = $sumPayment - $sumAccrual;
echo "Баланс: ";
echo ($state);


?>
 </h1>
 <?php

if ($state >= 0) {
?>
<p class="lead text-muted">Спасибо за своевременную оплату</p>
<?php
    
} else {
    
?>
          <p class="lead text-muted">Заплатите квартплату</p>
          <?php
}
?>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-2">
        <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="50" xmlns="http://www.w3.org/2000/svg" focusable="false"><title>Placeholder</title><rect width="100%" height="50" fill="#880000"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Начисления</text></svg>

<?php
mysqli_close($connection);
include 'connect.php';

$accruals = mysqli_query($connection, "SELECT sum, date from accrual where flat_id = {$flat_id} ORDER BY date DESC  ");
$accruals = mysqli_fetch_all($accruals, MYSQLI_ASSOC);
foreach ($accruals AS $accrual):
?>
           <div class="card-body">
              <p class="card-text"><?= $accrual['sum'] ?></p>
              <div class="d-flex justify-content-between align-items-center">
                
                <small class="text-muted"><?= $accrual['date'] ?></small>
              </div>
            </div>

 <?php
endforeach;
?>


          </div>
        </div>
        <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="50" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="50" fill="#008800"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Оплата</text></svg>

          
<?php
mysqli_close($connection);
include 'connect.php';

$payments = mysqli_query($connection, "SELECT sum, date from payment where flat_id = {$flat_id} ORDER BY date DESC ");
$payments = mysqli_fetch_all($payments, MYSQLI_ASSOC);
foreach ($payments AS $payment):
?>
           <div class="card-body">
              <p class="card-text"><?= $payment['sum'] ?></p>
              <div class="d-flex justify-content-between align-items-center">
                
                <small class="text-muted"><?= $payment['date'] ?></small>
              </div>
            </div>
            
 <?php
endforeach;
?>
         </div>
        </div>
      

        
          </div>
        </div>
      </div>
    </div>
  </div>

</main>

      
  

</body></html>