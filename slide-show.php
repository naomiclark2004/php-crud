<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Slideshow</title>
  <?php
  include("./style/styles.php");
  ?>
</head>

<body>
  <!-- Nav -->
  <?php

  include('view/menu.php');
  include('database.php');
  $db = new DB();

  $menu = new Menu($db);
  $menu->showMenu();
  ?>

  <!-- Header -->
  <?php
  $title = "Slideshow";
  include('view/header.php');
  $header = new Header($title);
  $header->showHeader();
  ?>

  <!-- Main Content -->
  <?php
  global $db;
  $result = $db->getImageInfo();

  echo
  "<div class='slideshow-container'>";

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {

      echo "<div class='mySlides fade'>
            <img src='./images/image" . $row['id'] . ".jpg' style='width:100%; height:500px'>
            <div class='text'>" . $row['img_name'] . "</div>
            </div>";
    }
  }

  echo "<button class='prev' onclick='plusSlides(-1)'>❮</button>
         <button class='next' onclick='plusSlides(1)'>❯</button>
    </div>";

  echo "<script>
            let slideIndex = 1;
            showSlides(slideIndex);

            function plusSlides(n) {
              showSlides(slideIndex += n);
            }

            function currentSlide(n) {
              showSlides(slideIndex = n);
            }

            function showSlides(n) {
              let i;
              let slides = document.getElementsByClassName('mySlides');
              let dots = document.getElementsByClassName('dot');
              if (n > slides.length) {slideIndex = 1}    
              if (n < 1) {slideIndex = slides.length}
              for (i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';  
              }
              for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(' active', '');
              }
              slides[slideIndex-1].style.display = 'block';  
              dots[slideIndex-1].className += ' active';
            }
          </script>"
  ?>

  <!-- Footer -->
  <?php
  include('view/footer.php')
  ?>
</body>

</html>