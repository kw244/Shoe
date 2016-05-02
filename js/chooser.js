    //returns the html for each shoe panel given its name and image path
    function getShoePanelHTML(name, image){
        var shoePanel= [
                '<div class="col-md-1 shoe-frame" data-name="'+name+'" data-img="'+image+'"=>',
                '  <div class= "image-frame">',
                '    <img src="resources/thumbnails/thumb-'+image+'" alt="" class="img-responsive">',
                '  </div>',
                '  <h6>'+name+'</h6>',
                '</div>'
            ].join("\n");
        return shoePanel; 
    }
    $(document).ready(function () {
        $("#chooser-panel .image-frame").on('mouseenter', function () {
            $(this).find(".fa-times").show();
        });
        $("#chooser-panel .image-frame").on('mouseleave', function () {
            $(this).find(".fa-times").hide();
        });
        
    });

    
    $(document).ready(function() {
        $.ajax({
            type:"GET",
            url:"database/get-shoes.php",
            dataType:"json",
            success: function(response){
                
                for(var i = 1; i <= response.length; i++){
                   $("#shoe-grid").append(getShoePanelHTML(response[i-1].name, response[i-1].image));                    
                
                    if(i % 12 === 0){
                        $("#shoe-grid").append('<div class="clearfix visible-md-block"></div>');
                    }
                }  
                
                $(".shoe-frame").click(function(){
                    var chooser1Image = $("#chooser-1").attr("src").slice(-10);
                    if(chooser1Image==="Shoe-1.png"){ //we load image into i-f-1 if it is empty
                        $("#chooser-1").attr("src","resources/thumbnails/thumb-" + $(this).data("img"));
                        $("#i-f-1").data("name",$(this).data("name"));
                    }
                    else{ //we load image into i-f-2
                        $("#chooser-2").attr("src","resources/thumbnails/thumb-" + $(this).data("img"));
                        $("#i-f-2").data("name",$(this).data("name"));
                    }
                });
                
                $("#chooser-panel .image-frame").click(function(){
                    var frameNum = $(this).attr("id").slice(-1); //get the frame number
                    $(this).children("img").attr("src","resources/thumbnails/Shoe-"+frameNum+".png"); //reset to the placeholder img
                    
                });
                
            }
        });
    });
    
    
    //button-click handler
    //if 2 shoes have been selected, direct to shoe-compare page, else stay on page and show alert
    $(document).ready(function(){
        $("#compare-btn").click(function(){
            var chooser1Image = $("#chooser-1").attr("src").slice(-10);
            var chooser2Image = $("#chooser-2").attr("src").slice(-10);
            if((chooser1Image==="Shoe-1.png")||(chooser2Image==="Shoe-2.png")){
                window.alert("Please select 2 shoes to compare!"); 
            }
            else{
                window.location = "shoe-compare.html?name-1=" + $("#i-f-1").data("name") +
                                    "&name-2=" + $("#i-f-2").data("name"); 
            }
        });
        
    });
    
