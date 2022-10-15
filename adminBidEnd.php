<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
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

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $select_delete_image = $conn->prepare("SELECT image FROM `stock` WHERE id = ?");
   $select_delete_image->execute([$delete_id]);
   $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
   unlink('uploaded_img/' . $fetch_delete_image['image']);
   $delete_products = $conn->prepare("DELETE FROM `stock` WHERE id = ?");
   $delete_products->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/home.css">

</head>

<body>

   <?php include 'admin_header.php'; ?>

   <section class="tables">

      <h1 class="title">Bid End</h1>

      <table>
         <thead>
            <tr>
               <th>No</th>
               <th>Symbol</th>
               <th>Price</th>
               <th>Profit</th>
               <th>Bid User</th>
               <th>Bid Price</th>
               <th>Bid End</th>
            </tr>
         </thead>

         <?php
         
         $show_products = $conn->prepare("SELECT * FROM `bidding`");
         $show_products->execute();
         if ($show_products->rowCount() > 0) {
            while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
               if ($fetch_products['bid_await'] == "await") {
                  # code...
                  //$max = $fetch_products['bid_value'];
                  //echo $max[0];
                  //echo max([$max]);
                  echo "<tr><td>" . $fetch_products['id'] . "<td/<td>" . $fetch_products['symbol'] . "<td/<td>" . $fetch_products['price'] . "<td/<td>" . $fetch_products['profit'] . "<td/<td>" . $fetch_products['bid_user'] . "<td/<td>" . $fetch_products['bid_value'] . "<td/<td>" . "<a class= bidButton href=adminConfermBitEnd.php?update=" . $fetch_products['id'] ."bidUpdate=" . $fetch_products['symbol'] . ">Bid End</a>";
               
               }
      
            }
            echo "</table>";
         ?>
      </table>

   <?php
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
   ?>

   </section>
   <script>
      $('#payment_status').on('change keypress keyup', function() {
         if ($(this).prop('checked') == true) {
            $('#amount').closest('.form-group').hide()
         } else {
            $('#amount').closest('.form-group').show()
         }
      })
      $('.jqte').jqte();

      $('#manage-product').submit(function(e) {
         e.preventDefault()
         start_load()
         $('#msg').html('')
         $.ajax({
            url: 'ajax.php?action=save_product',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
               if (resp == 1) {
                  alert_toast("Data successfully saved", 'success')
                  setTimeout(function() {
                     location.href = "index.php?page=products"
                  }, 1500)

               }

            }
         })
      })
      if (window.FileReader) {
         var drop;
         addproductHandler(window, 'load', function() {
            var status = document.getElementById('status');
            drop = document.getElementById('drop');
            var dname = document.getElementById('dname');
            var list = document.getElementById('list');

            function cancel(e) {
               if (e.preventDefault) {
                  e.preventDefault();
               }
               return false;
            }

            // Tells the browser that we *can* drop on this target
            addproductHandler(drop, 'dragover', cancel);
            addproductHandler(drop, 'dragenter', cancel);

            addproductHandler(drop, 'drop', function(e) {
               e = e || window.product; // get window.product if e argument missing (in IE)   
               if (e.preventDefault) {
                  e.preventDefault();
               } // stops the browser from redirecting off to the image.
               $('#dname').remove();
               var dt = e.dataTransfer;
               var files = dt.files;
               for (var i = 0; i < files.length; i++) {
                  var file = files[i];
                  var reader = new FileReader();

                  //attach product handlers here...

                  reader.readAsDataURL(file);
                  addproductHandler(reader, 'loadend', function(e, file) {
                     var bin = this.result;
                     var imgF = document.getElementById('img-clone');
                     imgF = imgF.cloneNode(true);
                     imgF.removeAttribute('id')
                     imgF.removeAttribute('style')

                     var img = document.createElement("img");
                     var fileinput = document.createElement("input");
                     var fileinputName = document.createElement("input");
                     fileinput.setAttribute('type', 'hidden')
                     fileinputName.setAttribute('type', 'hidden')
                     fileinput.setAttribute('name', 'img[]')
                     fileinputName.setAttribute('name', 'imgName[]')
                     fileinput.value = bin
                     fileinputName.value = file.name
                     img.classList.add("imgDropped")
                     img.file = file;
                     img.src = bin;
                     imgF.appendChild(fileinput);
                     imgF.appendChild(fileinputName);
                     imgF.appendChild(img);
                     drop.appendChild(imgF)
                  }.bindToproductHandler(file));
               }
               return false;

            });

            Function.prototype.bindToproductHandler = function bindToproductHandler() {
               var handler = this;
               var boundParameters = Array.prototype.slice.call(arguments);
               return function(e) {
                  e = e || window.product; // get window.product if e argument missing (in IE)   
                  boundParameters.unshift(e);
                  handler.apply(this, boundParameters);
               }
            };
         });
      } else {
         document.getElementById('status').innerHTML = 'Your browser does not support the HTML5 FileReader.';
      }

      function addproductHandler(obj, evt, handler) {
         if (obj.addproductListener) {
            // W3C method
            obj.addproductListener(evt, handler, false);
         } else if (obj.attachproduct) {
            // IE method.
            obj.attachproduct('on' + evt, handler);
         } else {
            // Old school method.
            obj['on' + evt] = handler;
         }
      }

      function displayIMG(input) {

         if (input.files) {
            if ($('#dname').length > 0)
               $('#dname').remove();

            Object.keys(input.files).map(function(k) {
               var reader = new FileReader();
               reader.onload = function(e) {
                  // $('#cimg').attr('src', e.target.result);
                  var bin = e.target.result;
                  var fname = input.files[k].name;
                  var imgF = document.getElementById('img-clone');
                  imgF = imgF.cloneNode(true);
                  imgF.removeAttribute('id')
                  imgF.removeAttribute('style')
                  var img = document.createElement("img");
                  var fileinput = document.createElement("input");
                  var fileinputName = document.createElement("input");
                  fileinput.setAttribute('type', 'hidden')
                  fileinputName.setAttribute('type', 'hidden')
                  fileinput.setAttribute('name', 'img[]')
                  fileinputName.setAttribute('name', 'imgName[]')
                  fileinput.value = bin
                  fileinputName.value = fname
                  img.classList.add("imgDropped")
                  img.src = bin;
                  imgF.appendChild(fileinput);
                  imgF.appendChild(fileinputName);
                  imgF.appendChild(img);
                  drop.appendChild(imgF)
               }
               reader.readAsDataURL(input.files[k]);
            })

            rem_func()

         }
      }

      function displayImg2(input, _this) {
         if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
               $('#img_path-field').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
         }
      }

      function rem_func(_this) {
         _this.closest('.imgF').remove()
         if ($('#drop .imgF').length <= 0) {
            $('#drop').append('<span id="dname" class="text-center">Drop Files Here</label></span>')
         }
      }
   </script>


   <script src="js/script.js"></script>

</body>

</html>