<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Новости</title>
  </head>


<?php
include 'navBar.php';

include 'connect.php';
$status = mysqli_query($connection, "SELECT status_id FROM tenant WHERE tenant.id = {$_COOKIE['userId']}");
mysqli_close($connection);

$status = mysqli_fetch_assoc($status);
$status = $status['status_id'];
if($status == 4){
?>


        <div id="accordion" role="tablist">

          <div class="card">
            <div class="card-header" role="tab" id="heading<?= $post['id'] ?>">
              <h5 class="mb-0">
                  Напишите новый пост
              </h5>
            </div>

            <form action="insertPost.php" method="POST" >
            <div class="input-group mb-0">

              <input type="hidden" name="author_id" value="<?php echo("{$_COOKIE['userId']}"); ?>">
              <input name="title" type="text" required="true" class="form-control" placeholder="Заголовок"  
                >
                <input name="text" type="text" required="true" class="form-control" placeholder="Текст"  
                >
                <button class="btn btn-outline-secondary" type="submit" >Send</button>
              </div>
            </form>
            <br>
            <br>
          </div>
          
        </div>






<?php

}


include 'connect.php';
$user = mysqli_query($connection, "SELECT CONCAT(tenant.surname, ' ' , tenant.name) AS name from tenant WHERE id = {$_COOKIE['userId']}");
$user = mysqli_fetch_all($user, MYSQLI_ASSOC);

$posts = mysqli_query($connection, "CALL getMainPosts()");
mysqli_close($connection);
$posts = mysqli_fetch_all($posts, MYSQLI_ASSOC);
foreach ($posts AS $post):
?>


          <div class="p-4 mb-4 bg-light rounded-3">
            <div class="container-fluid">
            <h1 class="display-7 fw-bold"><?= $post['title'] ?></h1>

            <p class="col-md-12 fs-4"><?= $post['text'] ?> </p>

        <div id="accordion" role="tablist">

          <div class="card">
            <div class="card-header" role="tab" id="heading<?= $post['id'] ?>">
              <h5 class="mb-0">
                <a data-toggle="collapse" href="#collapse<?= $post['id'] ?>" aria-expanded="true" aria-controls="collapse<?= $post['id'] ?>">
                  Комментарии
                </a>
              </h5>
            </div>


             <div id="collapse<?= $post['id'] ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?= $post['id'] ?>">

            <?php
    include 'connect.php';
    $comments = mysqli_query($connection, "CALL getPostComments({$post['id']})");
    $comments = mysqli_fetch_all($comments, MYSQLI_ASSOC);
    
    foreach ($comments AS $comment):
?>

              <div id="commentsForPost<?= $post['id'] ?>" class="list-group list-group-numbered">
                <div class="list-group-item"><span class="fw-bold"><?= $comment['name']; ?>: </span><?= $comment['text']; ?></div> 
              </div>
 <?php
    endforeach;
?>

              

            </div>
            <div class="input-group mb-3">
                <input id="commentInput<?= $post['id'] ?>" type="text" class="form-control" placeholder="Write a comment" aria-label="Recipient's username" 
                aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="fun1(<?= $post['id'] ?>)">Send</button>
              </div>
          </div>
          
        </div>
    
      </div>
    </div> 
      <?php
endforeach;
?>
 
  </div>
</main>

<script type="text/javascript">
  function fun1(post) {
    let commentInput = document.getElementById("commentInput" + post);
    let comment = commentInput.value;
    $.ajax({
      url: './insertComment.php',
      method: 'post',
      dataType: 'html',
      data: {postId: post, userComment: comment},
      success: function(data){
        commentInput.value = "";
        let newComment = document.createElement("div");
        newComment.className = "list-group-item";
        newComment.innerHTML = "<span class='fw-bold'><?= $user[0]['name'] ?> </span>" + comment;
        document.getElementById("collapse" + post).append(newComment);
      }
    });
  }
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


  </body>
</html>
