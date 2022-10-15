<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
};

if (isset($_POST['send'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if ($select_message->rowCount() > 0) {
      $message[] = 'already sent message!';
   } else {

      $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">





   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/home.css">

</head>

<body>


   <?php include 'header.php'; ?>

   <div class="heading-contact">
      <h3>Contact Us</h3>
      <p> <a href="home.php">Home</a> / Contact </p>
   </div>

   <section class="contact">

      <h1 class="title">Get In Touch</h1>


      <div class="container">
         <div class="row">
            <div class="col-md-6">
               <form action="" method="POST">
                  <input type="text" name="name" class="box" required placeholder="Enter Your Name">
                  <input type="email" name="email" class="box" required placeholder="Enter Your Email">
                  <input type="number" name="number" min="0" class="box" required placeholder="Enter Your Number">
                  <textarea name="msg" class="box" required placeholder="Enter Your Message" cols="30" rows="10"></textarea>
                  <input type="submit" value="send message" class="btn" name="send">
               </form>
            </div>
            <div class="col-md-6 contact-info">
               <div class="follow"><b>Address</b><i class="fa fa-map-marker"></i>  Colombo, Srilanka - 400104</div>

               <div class="follow"><b>Phone</b> <i class="fa fa-phone"></i>+123-456-7890</div>

               <div class="follow"><b>Email</b><i class="fa fa-envelope"></i> MiniProject@gmail.com</div>

               <div class="follow"><label><b>Get Social</b></label>
                  <a href="#"><i class="fab fa-facebook"></i></a>
                  <a href="#"><i class="fab fa-youtube-play"></i></a>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-google-plus"></i></a>
               </div>
            </div>
         </div>
      </div>

   </section>






   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>