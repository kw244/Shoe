
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
    $(document).ready(function() {
        //we get the names of the shoes to compare from query string
        var name_1 = getParameterByName('name-1');
        var name_2 = getParameterByName('name-2');
        
        $.ajax({
            type:"GET",
            data:{'name_1': name_1, 'name_2': name_2},
            url:"database/get-shoes-compare.php",
            dataType:"json",
            success: function(response){   
                for(var i=0; i<response.length; i++){
                    console.log(convertObj(response[i]));
                }
                    
            }
        });
    });