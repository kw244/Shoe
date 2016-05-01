<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Shoe</title>
  <link rel="icon" href="resources/logo.png">
  
  <!-- Stylesheets -->
  <!-- TODO remove unused css rules-->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

</head>

<body>

<!-- Start Header -->
<header id="header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="logo">
          <a href="#"><img src="resources/logo.png" alt="logo" class="img-responsive"></a>
          <span class="company-name"><p>Shoe</p></span>
        </div>
        <div class="navigation">
          <nav>
            <ul class="custom-list list-inline">
              <li><a href="#">Home</a></li>
              <li><a href="#events">Blog</a></li>
              <li><a href="#faq">Contact Us</a></li>
              <li><a href="#hero" class="btn btn-red">Sign Up</a></li>
            </ul>
          </nav>
          <i class="fa fa-list toggleMenu"></i>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- End Header -->



<!-- Start About -->
<section id="shoes">
  <div class="container">
    
    <div class="row">
        
        <div class="col-md-8 col-md-offset-2 preamble">
            <h3>Shoe Selector</h3>
        </div>   
        <!-- grid of shoes gets populated here -->
        <!-- TODO specify img size to speed up page display-->
        <div class="col-md-12" id="shoe-grid">
        </div>
        
    </div>
    
  </div>
 
</section>
<!-- End About -->

<div id="chooser-panel">
        <div class="col-md-2">
            <h4>Select 2 shoes to compare</h4>
            
        </div>
        <div class="row">
            <div class= "image-frame" id="i-f-1">
                <img src="resources/thumbnails/Shoe-1.png" alt="" class="img-responsive" id="chooser-1">
                <i class="fa fa-times"></i>
            </div>
            

            <div class="image-frame"  id="i-f-2">
                <img src="resources/thumbnails/Shoe-2.png" alt="" class="img-responsive" id="chooser-2">
                <i class="fa fa-times"></i>
            </div>
            <button class="btn btn-red">Compare shoes</button>
        </div>
</div>


<!-- Scripts -->
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/scripts.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/jquery.ba-outside-events.min.js"></script>
<script src="js/jquery.ui.min.js"></script>
<script src="js/chooser.js"></script>

</body>
</html>
