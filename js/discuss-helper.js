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
    
    /**  Get shoe name to load Disqus forum **/
    var shoe_name = getParameterByName('shoe-name');
    $("#discuss-title").text(shoe_name);
    
    $.ajax({
        type:"GET",
        data:{'name_1': shoe_name},
        url:"database/get-shoes-discuss.php",
        dataType:"json",
        success: function(response){ 
            $("#discuss-image").attr("src","resources/thumbnails/thumb-" + response[0].image);
        }
    });