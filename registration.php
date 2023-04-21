
<!doctype html>
<html lang="ru">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ОСМД Дружба">

    <title>Registration</title>

    <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

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

    
    <link href="css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<main class="form-signin">
  <form action="insertTenant.php" method="POST" >
    
    <h1 class="h3 mb-3 fw-normal">Registration</h1>

    <div class="form-floating">
      <input name="flat" type="number" class="form-control" placeholder="Apartment number">
      <label for="floatingInput">Apartment number</label>
    </div>
    <div class="form-floating ">
      <input name="surname" type="text" class="form-control"  placeholder="Surname">
      <label for="floatingPassword">Surname</label>
    </div>
    <div class="form-floating">
      <input name="name" type="text" class="form-control"  placeholder="Name">
      <label for="floatingInput">Name</label>
    </div>
    <div class="form-floating">
      <input name="middle_name" type="text" class="form-control"  placeholder="Patronymic">
      <label for="floatingInput">Patronymic</label>
    </div>
    <div class="form-floating">
      <input name="phone" type="number" class="form-control" placeholder="Phone number">
      <label for="floatingInput">Phone number</label>
    </div>
    <div class="form-floating">
      <input name="email" type="email" class="form-control" placeholder="Email">
      <label for="floatingInput">Email/label>
    </div>
    <div class="form-floating mb-2 ">
      <input name="password" type="text" class="form-control" placeholder="Password">
      <label for="floatingInput">Password</label>
    </div>

    <h1  class="h6 mb-3 fw-normal"><a class="" href="signin.php">Login</a></h1>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>

  </form>


</main>


  </body>
</html>