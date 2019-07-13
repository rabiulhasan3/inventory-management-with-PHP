<?php 
    include("database_connection.php");

    if(isset($_SESSION['type'])){
      header("location:index.php");
    }

    $message = '';
    if(isset($_POST['login'])){
      $query = "SELECT * FROM user_details WHERE user_email = :user_email";
      $statement = $connect->prepare($query);
      $statement->execute(
                      array(
                          'user_email' => $_POST["user_email"]
                      )
                  );
      $count = $statement->rowCount();

      if($count > 0){
        $result = $statement->fetchAll();
        foreach($result as $key=>$row){
          if(password_verify($_POST['user_password'], $row['user_password'])){
            // check user status 
            if($row['user_status'] == 'Active'){
              $_SESSION['type'] = $row['user_type'];
              $_SESSION['user_id'] = $row['user_id'];
              $_SESSION['user_name'] = $row['user_name'];
              header("location:index.php");
            }else{
              $message.= '<div class="alert alert-danger">Your Account is Disabled. Please contact the Authority. !</div>'; 
            }
          }else{
            $message.= '<div class="alert alert-danger">Wrong Password !</div>';
          }
        }
      }
    }
 ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <div class="mt-5">
            <form action="" method="post">
              <label for="">Email</label>
              <input type="email" name="user_email" placeholder="Email" class="form-control">
              <label for="Password">Password</label>
              <input type="password" name="user_password" placeholder="Password" class="form-control">
              <br>
              <input type="submit" name="login" class="btn btn-success" value="login">
            </form>

            <?php
              echo '<br>'; 
              echo $message;
             ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>