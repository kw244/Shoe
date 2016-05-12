    //converts the data from database request to be D3 friendly
    function convertObj(shoeObj){
        var categories = ["traction", "cushion", "materials", "fit", "support"];
        var shoe=[];
        for(var key in shoeObj){
            if(categories.indexOf(key)>=0){
                shoe.push({name:key, value: shoeObj[key]});
            }
        }
        return shoe;
    }
    
    //parses the query string from url
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
    
    
    /**  Prepares shoe information for visual comparison **/
    var name_1 = getParameterByName('name-1');
    var name_2 = getParameterByName('name-2');
        
    $.ajax({
        type:"GET",
        data:{'name_1': name_1, 'name_2': name_2},
        url:"database/get-shoes-compare.php",
        dataType:"json",
        success: function(response){   
        
            //we update the name of the shoes       
            $("#shoe-name-1").text(name_1);
            $("#shoe-name-2").text(name_2);

            //update the table with comparison information
            $("#shoe-price td:nth-child(2)").html("$"+response[0].price);
            $("#shoe-price td:nth-child(3)").html("$"+response[1].price); 
            $("#shoe-blurb td:nth-child(2)").html(response[0].blurb);
            $("#shoe-blurb td:nth-child(3)").html(response[1].blurb);
            
            //generate the list of shoe tech for comparison
            var tech_1 = response[0].tech.split(",");
            var tech_2 = response[1].tech.split(",");
            var tech_1_list = "";
            var tech_2_list = "";
            for(var i=0; i < tech_1.length; i++){
                tech_1_list = tech_1_list + "<li>" + tech_1[i] + "</li>";
            }
            for(var j=0; j < tech_2.length; j++){
                tech_2_list = tech_2_list + "<li>" + tech_2[j] + "</li>";
            }
            tech_1_list = "<ul>" + tech_1_list + "</ul>";
            tech_2_list = "<ul>" + tech_2_list + "</ul>";
            $("#shoe-tech td:nth-child(2)").html(tech_1_list);
            $("#shoe-tech td:nth-child(3)").html(tech_2_list);
            
            
            
            //figure out number of extra images for gallery and root filename
            var extra_i = +response[0].extra;
            var extra_j = +response[1].extra;
            var img_1_root = response[0].image.slice(0,-4);
            var img_2_root = response[1].image.slice(0,-4);
            
            //setup image gallery: generate the html framework for Swiper plugin
            var temp_img_html_1 = '<div class="swiper-wrapper">';
            temp_img_html_1 += '<div class="swiper-slide"><img class="shoe-image" src="resources/thumbnails/thumb-' + response[0].image + '"></div>';
            for(var i=2; i<= extra_i; i++){
                temp_img_html_1 += '<div class="swiper-slide"><img class="shoe-image" src="resources/extra/' + img_1_root + '-' + i + '.png"></div>';
            }
            temp_img_html_1 += '</div><div class="swiper-pagination"></div>';

            $("#shoe-images-1").html(temp_img_html_1);
            $("#dialog-1-content").html(temp_img_html_1);
            
            //rinse and repeat for second shoe's image gallery
            var temp_img_html_2 = '<div class="swiper-wrapper">'; 
            temp_img_html_2 += '<div class="swiper-slide"><img class="shoe-image" src="resources/thumbnails/thumb-' + response[1].image + '"></div>';
            for(var j=2; j<= extra_j; j++){
                temp_img_html_2 += '<div class="swiper-slide"><img class="shoe-image" src="resources/extra/' + img_2_root + '-' + j + '.png"></div>';
            }
            temp_img_html_2 += '</div><div class="swiper-pagination"></div>';

            $("#shoe-images-2").html(temp_img_html_2);
            $("#dialog-2-content").html(temp_img_html_2);
        
            //we draw the bar chart comparing the shoes
            draw(convertObj(response[0]), convertObj(response[1]));       
            
            //generate links to the respective Disqus forums 
            $("#shoe-discuss td:nth-child(2)").html('<a href="discuss.html?shoe-name=' + name_1 + '">Discuss the ' + name_1 + ' here</a>');
            $("#shoe-discuss td:nth-child(3)").html('<a href="discuss.html?shoe-name=' + name_2 + '">Discuss the ' + name_2 + ' here</a>');
            
            
            $(document).ready(function () {
                //initialize swiper when document ready  
                var mySwiper = new Swiper ('.swiper-container', {
                  // Optional parameters
                  direction: 'horizontal',
                  loop: true,
                  // If we need pagination
                  pagination: '.swiper-pagination'
                }); 
                
                $("#dialog-1").dialog({
                    autoOpen: false,
                    width: 240,
                    title: name_1
                });
                $("#dialog-2").dialog({
                    autoOpen: false,
                    width: 240,
                    title: name_2
                });
                
                //we check if either swiper container is clicked
                $("#shoe-images-1").click(function(){
                    var msg = "Screen 1 was clicked";
                    $("#dialog-1").dialog("open");
                    
                });
                $("#shoe-images-2").click(function(){
                    var msg = "Screen 2 was clicked";
                    $("#dialog-2").dialog("open");
                    
                });
                
                
                      
            });
        }
    });