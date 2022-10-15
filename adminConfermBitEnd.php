<?php

@include 'config.php';

session_start();

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
    $bid_user = $_POST['bid_user'];
    $bid_user = filter_var($bid_user, FILTER_SANITIZE_STRING);
    $bid_value = $_POST['bid_value'];
    $bid_value = filter_var($bid_value, FILTER_SANITIZE_STRING);
    $bid_end_datetime = $_POST['bid_end_datetime'];
    $bid_end_datetime = filter_var($bid_end_datetime, FILTER_SANITIZE_STRING);

    $bid_await = "done";

    $select = $conn->prepare("SELECT * FROM `biddingwins` WHERE bid_value = ?");
    $select->execute([$bid_value]);

    if ($select->rowCount() > 0) {
        # code...
        $message[3] = 'Error';
    } else {
        if ($bid_value > $details) {
            # code...
            $update_product = $conn->prepare("INSERT INTO `biddingwins`(symbol, price, security, profit, bid_user, bid_value, bid_end_datetime) VALUES(?,?,?,?,?,?,?)");
            $update_product->execute([$name, $price, $category, $details, $bid_user, $bid_value, $bid_end_datetime]);

            $update_values = $conn->prepare("UPDATE `stock` SET bid_value = ? WHERE symbol = ?");
            $update_values->execute([$bid_await, $name]);

            $update_await = $conn->prepare("UPDATE `bidding` SET bid_await = ? WHERE symbol = ?");
            $update_await->execute([$bid_await, $name]);

            $message[1] = 'Bid End successfully!';
        } else {
            $message[2] = "Error";
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
    <title>update products</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/bit.css">

</head>

<body>

    <?php

    if (isset($message[2])) {
        foreach ($message as $message) {
            echo '
      <div class="messages">
      <img src="./assets/error.png" alt="">
      <h2>Sorry!</h2>
      <a href="adminBidEnd.php">
         <span>' . $message . '</span>
         <button type="button" onclick="this.parentElement.remove();">Ok</button>
      </div>
      ';
        }
    } else if (isset($message[1])) {
        foreach ($message as $message) {
            echo '
      <div class="messages">
      <img src="./assets/404-tick.png" alt="">
      <h2>Successfully!</h2>
         <span>' . $message . '</span>
         <a href="adminBidEnd.php">
         <button type="button" onclick="this.parentElement.remove();">Ok</button>
         </a>
      </div>
      ';
        }
    } else if (isset($message[3])) {
        # code...
        foreach ($message as $message) {
            echo '
      <div class="messages">
      <img src="./assets/error.png" alt="">
      <h2>Sorry!</h2>
      <a href="adminBidEnd.php">
         <span>' . $message . '</span>
         <button type="button" onclick="this.parentElement.remove();">Ok</button>
      </div>
      ';
        }
    }

    ?>

    <section class="update-product">

        <?php
        $update_id = $_GET['update'];
        $select_products = $conn->prepare("SELECT * FROM `bidding` WHERE id = ?");
        $select_products->execute([$update_id]);
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div">
                    <div>
                        <br>
                        <form action="" method="post">
                            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                            <input type="hidden" name="symbol" placeholder="Enter Stock Name" required class="box" value="<?= $fetch_products['symbol']; ?>">
                            <input type="hidden" name="price" min="0" placeholder="Enter Stock security" required class="box" value="<?= $fetch_products['price']; ?>">
                            <input type="hidden" name="security" min="0" placeholder="Enter Stock security" required class="box" value="<?= $fetch_products['security']; ?>">
                            <input type="hidden" name="profit" min="0" placeholder="Enter Stock Profit" required class="box" value="<?= $fetch_products['profit']; ?>">

                            <input type="hidden" name="bid_user" min="0" placeholder="Enter Stock Profit" required class="box" value="<?= $fetch_products['bid_user']; ?>">

                            <input type="hidden" name="bid_value" min="0" placeholder="Enter Stock Profit" required class="box" value="<?= $fetch_products['bid_value']; ?>">

                            <input type="hidden" name="bid_end_datetime" min="0" placeholder="Bidding End Date/Time" required class="box" value="<?= $fetch_products['bid_end_datetime']; ?>">
                            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                            <div class="flex-btn">
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    Confirm You Want Bit End
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">You Want to End Bit</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><?= $fetch_products['symbol']; ?></li>
                                    <li class="list-group-item"><?= $fetch_products['bid_user']; ?></li>
                                    <li class="list-group-item"><?= $fetch_products['bid_value']; ?></li>
                                </ul>
                                <input type="submit" class="btn-end" value="End" name="update_product">
                            </div>
                    </div>




                    </form>
                    </div>

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