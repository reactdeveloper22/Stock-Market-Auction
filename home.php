<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if (isset($_POST['add_product'])) {

   $name = $_POST['symbol'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['security'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $details = $_POST['profit'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);
   $bid_end_datetime = $_POST['bid_end_datetime'];
   $bid_end_datetime = filter_var($bid_end_datetime, FILTER_SANITIZE_STRING);
   $date_created = $_POST['date_created'];
   $date_created = filter_var($date_created, FILTER_SANITIZE_STRING);

   /*
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   */

   $select_products = $conn->prepare("SELECT * FROM `stock` WHERE name = ?");
   $select_products->execute([$name]);

   if ($select_products->rowCount() > 0) {
      $message[] = 'Stock name already exist!';
   } else {

      $insert_products = $conn->prepare("INSERT INTO `stock`(symbol, price, security, profit, bid_end_datetime) VALUES(?,?,?,?,?)");
      $insert_products->execute([$name, $price, $category, $details, $bid_end_datetime]);

      if ($insert_products) {
         $message[] = 'New Stock Add!';
      }
   }
};

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

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/home.css">

</head>
<body>
 

<?php include 'header.php'; ?>
<div class="heading-stock">
      <h3>Stock Market Auction</h3>
   </div>


<section class="tables">

<h1 class="title">Stock Added</h1>

<table>
   <thead>
      <tr>
         <th>No</th>
         <th>Symbol</th>
         <th>Price</th>
         <th>Security</th>
         <th>Profit</th>
         <th>Date Created</th>
         <th>Bidding End Date/Time</th>
         <th>Action</th>
      </tr>
   </thead>

   <?php
   $show_products = $conn->prepare("SELECT * FROM `stock`");
   $show_products->execute();
   if ($show_products->rowCount() > 0) {
      while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {

         if ($fetch_products['bid_value'] == "await") {
            echo "<tr><td>" . $fetch_products['id'] . "<td/<td>" . $fetch_products['symbol'] . "<td/<td>" . $fetch_products['price'] . "<td/<td>" . $fetch_products['security'] . "<td/<td>" . $fetch_products['profit'] ."<td/<td>" . $fetch_products['date_created'] . "<td/<td>" . $fetch_products['bid_end_datetime'] .
            "<td/<td>" . "<a class= option href=view.php?update=" . $fetch_products['id'] . ">View</a>" .
            "</td/<td>";
         }
      }
      echo "</table>";
   ?>
</table>

<?php
   } else {
      echo '<p class="empty">no STOCK added yet!</p>';
   }
?>

</section>
<?php include 'footer.php'; ?>


<script src="js/script.js"></script>

</body>
</html>