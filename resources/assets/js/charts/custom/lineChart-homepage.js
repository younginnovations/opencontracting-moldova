var element = $("#linechart-homepage");
var widthOfParent = element.parent().width();

var width = widthOfParent;
var height = 200;

var createLineChart = function(data){

    var svg = d3.select("#linechart-homepage")
                .append("svg")
                .attr("width", width + 1)
                .attr("height", height)
                .attr("id", "visualization");
    var vis = d3.select("#visualization"),
                margin = {
                    top: 20, right:20, bottom:20, left: 50
                };

    var xScale = d3.scale.ordinal().rangeRoundBands([0,width - 50], 0);
    var yScale = d3.scale.linear()
                .range([height - margin.top, margin.bottom]);
    var xAxis = d3.svg.axis()
                    .orient("bottom")
                    .scale(xScale)
                    .ticks(2);
    var yAxis = d3.svg.axis()
                    .orient("left")
                    .scale(yScale)
                    .ticks(6);

    function make_x_axis(){
        return d3.svg.axis()
                .scale(xScale)
                .orient("bottom")
                .ticks(5)
    }
    function make_y_axis(){
        return d3.svg.axis()
                .scale(yScale)
                .orient("left")
                .ticks(5)
    }
        data.forEach(function (d){
            d.xValue = d.xValue;
            d.chart1 = +d.chart1;
            d.chart2= +d.chart2;
        });
        var maxValue = d3.max(data, function(d){ return d.chart2; });
        xScale.domain(data.map(function (d) {return d.xValue; }));
        yScale.domain([0,maxValue]);

        vis.append("svg:g")
            .attr("class","axis")
            .attr("transform", "translate(" + (margin.left) + "," + (height - margin.bottom)+ ")")
            .call(xAxis);

        // vis.append("svg:g")
        // 	.attr("class","grid")
        // 	.attr("transform", "translate(" + (margin.left) + "," + (height - margin.bottom)+ ")")
        // 	.call(make_x_axis()
        // 			.tickSize(-height+margin.top, 0 ,0 )
        // 			.tickFormat("")
        // 		)
        vis.append("svg:g")
            .attr("class","axis")
            .attr("transform", "translate(" + margin.left + ",0)")
            .call(yAxis);

        vis.append("svg:g")
            .attr("class","grid")
            .attr("transform", "translate(" + margin.left + ",0)")
            .call(make_y_axis()
                    .tickSize(-width,0,0)
                    .tickFormat("")
                )

        var lineGen1 = d3.svg.line()
                    .x(function (d) {
                        return xScale(d.xValue);
                    })
                    .y(function (d) {
                        return yScale(d.chart1);
                    });
                    // .interpolate("basis");
        vis.append('svg:path')
            .attr('d', lineGen1(data))
            .attr("transform", "translate(" + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left) + ",0)")
            .attr("stroke", "grey")
            .attr("stroke-width", 2)
            .attr("fill", "none");

        var lineGen2 = d3.svg.line()
                    .x(function (d) {
                        return xScale(d.xValue);
                    })
                    .y(function (d) {
                        return yScale(d.chart2);
                    });

        vis.append('svg:path')
            .attr('d', lineGen2(data))
            .attr("transform", "translate(" + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left) + ",0)")
            .attr("stroke", "#ccc")
            .attr("stroke-width", 2)
            .attr("fill", "none");

        vis.selectAll("dot")
            .data(data)
            .enter()
            .append("circle")
            .filter(function (d) {
                return d.chart1;
            })
            .attr("r", 3)
            .attr("fill", "blue")
            .attr("cx", function (d){
                return xScale(d.xValue) + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left);
            })
            .attr("cy", function (d){
                return yScale(d.chart1);
            });

        vis.selectAll("dot")
            .data(data)
            .enter()
            .append("circle")
            .filter(function (d) {
                return d.chart2;
            })
            .attr("r", 3)
            .attr("fill", "red")
            .attr("cx", function (d){
                return xScale(d.xValue) + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left);
            })
            .attr("cy", function (d){
                return yScale(d.chart2);
            });

};

// Calling the function that creates the linechart
//createLineChart(data);
