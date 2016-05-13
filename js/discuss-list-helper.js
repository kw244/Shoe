    //returns the html for each discussion list item given its name
    function getDiscussPanelHTML(name){
        var discussPanel= [
                '<a class="list-group-item" href="http://blocksacademy.com/shoe/discuss.html?shoe-name=' + name + '">',
                '  <span class="disqus-comment-count badge" data-disqus-url="http://blocksacademy.com/shoe/discuss.html?shoe-name=' + name + '">hmm</span>',             
                   name,
                '</a>'
                ].join("\n");
        return discussPanel; 
    }
    $(document).ready(function(){
        $.ajax({
            type:"GET",
            url:"database/get-shoes.php",
            dataType:"json",
            success: function(response){   
                //dynamically create discussion listing with shoes from database
                for(var i = 1; i <= response.length; i++){
                   $("#discussion-grid").append(getDiscussPanelHTML(response[i-1].name));                    
                }
                DISQUSWIDGETS.getCount({reset: true});
            }
        });
    });