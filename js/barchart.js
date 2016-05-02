		function draw(shoe_1, shoe_2){
			"use strict";
			//setup dimensions for our chart
			var margin = { 	left: 100,
							right:50,
							top:25,
							bottom:25
						};
            var middlePadding = 5; //gap in between the back-to-back barcharts
			var width = 800 - margin.left - margin.right - middlePadding,
				height = 250 - margin.top - margin.bottom;
				
			//setup our svg		
			var svg = d3.select("#barchart")
					.append("svg")
                    .attr("preserveAspectRatio", "xMinYMin meet")
                    .attr("viewBox", "0 0 800 500");
                    
					
			//setup our embedded chart		
			var chart2 = svg.append("g")
						.attr("class","chart")
						.attr("transform", "translate(" + (margin.left + width/2 + middlePadding) + "," + margin.top + ")");
            var chart1 = svg.append("g")
						.attr("class","chart")
						.attr("transform", "translate(" + margin.left + "," + margin.top + ")");        
            
			//setup our x, y scales
			var xScale = d3.scale.linear()
						.domain([0, 5])
						.range([0,width/2]);
			var yScale = d3.scale.ordinal()
						.domain(["traction", "cushion", "materials", "fit", "support"]) //for each shoe attribute
						.rangeBands([0, height],0.2);

			var bar2 = chart2.selectAll("g")
                .data(shoe_2)
                .enter()
                    .append("g");
            var bar1 = chart1.selectAll("g")
                .data(shoe_1)
                .enter()
                    .append("g");
                    
            bar2.append("rect")
                .attr("class","bar2")
                .attr("x", 0)
                .attr("y", function(d){ return yScale(d.name); })
                .attr("height", yScale.rangeBand())
                .attr("width", function(d){ return xScale(d.value); });
                
            bar1.append("rect")
                .attr("class","bar1")
                .attr("x", function(d){ return width/2 - xScale(d.value);})
                .attr("y", function(d){ return yScale(d.name); })
                .attr("height", yScale.rangeBand())
                .attr("width", function(d){ return xScale(d.value); });
  
            bar1.append("text")
              .attr("x", -margin.left/2)
              .attr("y", function(d){ return yScale(d.name) + yScale.rangeBand()/2; })
              .attr("dy", '0.35em')
              .text(function(d) { return d.name.toUpperCase(); });
              
            
		}