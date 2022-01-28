<?php
$con = mysqli_connect('localhost','root');

if($con){
    echo "Connection successful";
}
else{
    echo "no connection";
}
mysqli_select_db($con,'userfield');

$user =$_POST['user'];
$email =$_POST['email'];
$password =$_POST['password'];
$comment =$_POST['comment'];

$query = "insert into infodata (user,email,password,comment)
values('$user','$email','$password','$comment')";

echo "$query";

mysqli_query($con, $query);

header('location:index.php');
 ?>
  