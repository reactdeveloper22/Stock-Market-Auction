<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_POST['update_product'])) {

   $pid = $_POST['pid'];
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


   $update_product = $conn->prepare("UPDATE `stock` SET symbol = ?, price = ?, 	security = ?, profit = ?, bid_end_datetime = ?  WHERE id = ?");
   $update_product->execute([$name, $price, $category, $details, $bid_end_datetime, $pid]);

   $message[] = 'Stock updated successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

   <?php include 'admin_header.php'; ?>

   <section class="update-product">

      <h1 class="title">Update Stock</h1>

      <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `stock` WHERE id = ?");
      $select_products->execute([$update_id]);
      if ($select_products->rowCount() > 0) {
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <form action="" method="post" enctype="multipart/form-data">
               <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
               <input type="text" name="symbol" placeholder="Enter Stock Name" required class="box" value="<?= $fetch_products['symbol']; ?>">
               <input type="number_format" name="price" min="0" placeholder="Enter Stock security" required class="box" value="<?= $fetch_products['price']; ?>">
               <input type="number" name="security" min="0" placeholder="Enter Stock security" required class="box" value="<?= $fetch_products['security']; ?>">
               <input type="number" name="profit" min="0" placeholder="Enter Stock Profit" required class="box" value="<?= $fetch_products['profit']; ?>">

               <input type="datetime-local" name="bid_end_datetime" min="0" placeholder="Bidding End Date/Time" required class="box" value="<?= $fetch_products['bid_end_datetime']; ?>">

               <div class="flex-btn">
                  <input type="submit" class="btn" value="update Stock" name="update_product">
                  <a href="admin_products.php" class="option-btn">Go back</a>
               </div>
            </form>
      <?php
         }
      } else {
         echo '<p class="empty">no products found!</p>';
      }
      ?>

   </section>













   <script src="js/script.js"></script>

</body>

</html>