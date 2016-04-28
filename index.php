<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Shoe</title>
  <link rel="icon" href="resources/logo.png">
  
  <!-- Stylesheets -->
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
        <div class="col-md-12" id="shoe-grid">
        </div>
        
    </div>
    
  </div>
 
</section>
<!-- End About -->

<div id="chooser-panel">

</div>


<!-- Scripts -->
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/scripts.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/jquery.ba-outside-events.min.js"></script>
<script src="js/jquery.ui.min.js"></script>

<script type="text/javascript">
    //returns the html for each shoe panel given its name and image path
    function getShoePanelHTML(name, image){
        var shoePanel= [
                '<div class="col-md-1 shoe-frame">',
                '  <div class= "image-frame">',
                '    <img src="'+image+'" alt="" class="img-responsive">',
                '  </div>',
                '  <h6>'+name+'</h6>',
                '</div>'
            ].join("\n");
        return shoePanel; 
    }

    $(document).ready(function() {
        $.ajax({
            type:"GET",
            url:"database/get-shoes.php",
            dataType:"json",
            success: function(response){
                console.log(response);
                
                for(var i = 1; i <= response.length; i++){
                   $("#shoe-grid").append(getShoePanelHTML(response[i-1].name, response[i-1].image));                    
                
                    if(i % 12 === 0){
                        $("#shoe-grid").append('<div class="clearfix visible-md-block"></div>');
                        console.log(response[i-1].name);
                    }
                }      
            }
        });
    });

</script>

</body>
</html>
