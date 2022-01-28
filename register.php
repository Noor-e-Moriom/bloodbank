<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>books4u</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" />
    
</head>

<body>
<?php

include 'info.php';

if(isset($_POST['submit'])){
    $user =mysqli_real_escape_string($con,$_POST['user']);
    $email =mysqli_real_escape_string($con,$_POST['email']);
    $password =mysqli_real_escape_string($con,$_POST['password']);
    $cpassword =mysqli_real_escape_string($con,$_POST['cpassword']);
    $comment =mysqli_real_escape_string($con,$_POST['comment']);

    $pass = password_hash($password, PASSWORD_BCRYPT);
    $cpass = password_hash($cpassword, PASSWORD_BCRYPT);

    $token =bin2hex(random_bytes(15));


    $emailquery ="select * from infodata where email ='$email' ";
    $query =mysqli_query($con, $emailquery);

    $emailcount = mysqli_num_rows($query);

    if($emailcount>0){
        echo "email already exists";
    }
    else{
        if($password === $cpassword ){  

            $insertquery ="insert into infodata (user,email,password,cpassword,comment,token,status)
            values('$user','$email','$pass','$cpass ','$token','$comment','inactive')";
            /*checked*/
            $iquery =mysqli_query($con,$insertquery);

            if($iquery){
                   
                   $subject ="Email activation";
                   $body ="Hi, $user.Click here to activate your account 
                   http://localhost/books4U/activate.php?token=$token";
                   $sender_email ="From:nooremoriom@gmail.com";
                   if(mail( $email,$subject,$body,$sender_email)){
                     $_SESSION['msg'] ="Check your mail to activate your account $email";

                     header('location:login.php');
                   }else{
                     echo "Email sending failed";
                   }
            
                }else{ 
              ?>
              <script>
                alert("Not inserted");
              </script>
             <?php
            }

        }
        else{
          ?>
              <script>
                alert("password did not matched");
              </script>
             <?php
        }
    }
}

?>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
  <a class="navbar-brand" href="#"> <h1 class="titl" style="color:">Books<sup style="color:#156A69">4</sup>U</h1></a>
    
    <form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"></a>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto ">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php" target="blank">Home</a>
        </li>
        <li class="nav-item">
          <a  class="nav-link"  href="about.php" target="blank">Biographies</a>
        </li>
        <li class="nav-item">
          <a  class="nav-link"  href="about.php" target="blank">Mystery & Thriller</a>
        </li>
        <li class="nav-item">
          <a  class="nav-link"  href="about.php" target="blank">About</a>
        </li>
        <li class="nav-item">
          <a id= "active" class="nav-link active" aria-current="page" href="register.php" target="blank">Contact & feedback</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="findus.php" target="blank">Find Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="rmncbook.php" target="blank">Romance</a>
        </li>
      
        <div class="dropdown">
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    More
  </a>
  <li class="dropdown-menu">
    <a target="blank" class="dropdown-item" href="fiction.php">Fiction</a>
    <a target="blank" class="dropdown-item" href="science.php">Science related</a>
    <a target="blank" class="dropdown-item" href="math.php">Math books</a>
</li>
</div>
        
      </ul>
      
   
</nav>

<section class ="my-5 m-auto" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.5); width:600px;background:#; ">
      <div class="py-5" >
        <h2 class =text-center>Contact Us</h2>
      </div>
  <div class="w-50 m-auto">
  
  <p>
      <a href="https://www.google.com" class="btn btn-block btn-gmail"><i class ="fa fa-google"></i>
      Login via google
      </a>
      <a href="" class="btn btn-block btn-facebook"><i class ="fa fa-facebook"></i>
      Login via facebook
      </a>
  </p>
  <p class ="divider-text">
  <span class="bg-light">OR</span><br><br>
  </p>
  
  <form action="view.php" method="POST">
  <div class="form-group">
      <label>Username:</label>
      <input type="text" name ="user" autocomplete="off" class="form-control" placeholder="Enter your name" >
    </div>
    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" class="form-control" id="email" name="email"  autocomplete="off" placeholder="Enter email"required >
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" name="password"  autocomplete="off" placeholder="password" >
    </div>
    <div class="form-group">
      <label for="pwd">Confirm Password:</label>
      <input type="password" class="form-control" id="pwd" name="cpassword"  autocomplete="off" placeholder="password" >
    </div>
    <div class="form-group">
      <label>Comments:</label>
      <textarea class="form-control" name ="comment" id="textarea" autocomplete="off">

      </textarea>
    </div>
    <button type="submit" name ="submit" class="btn btn-success">Submit</button>
  </form>
</div>
</section>
<footer>
    <p class ="p-3 bg-gray  text-center">
    <a class="p-3 text-teal" href ="#">Facebook</a>
        <a class="p-3 text-teal" href ="#">contact us</a>
        <a class="p-3 text-teal" href ="#">Twitter</a>
</p>
</footer>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>   
</body>
</html>