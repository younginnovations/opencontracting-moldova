var element1 = $("#linechart-rest");
var widthOfParent1 = element1.parent().width();

var width1 = widthOfParent1;
var height1 = 250;
var createLineChartRest = function(data){
    console.log(data);
    var svg = d3.select("#linechart-rest")
                .append("svg")
                .attr("width", width1 + 1)
                .attr("height", height1)
                .attr("id", "visualization");
    var vis = d3.select("#visualization"),
                margin = {
                    top: 20, right:20, bottom:20, left: 50
                };

    var xScale = d3.scale.ordinal().rangeRoundBands([0,width1-50], 0);
    var yScale = d3.scale.linear()
                .range([height1 - margin.top, margin.bottom]);
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
            .attr("transform", "translate(" + (margin.left) + "," + (height1 - margin.bottom)+ ")")
            .call(xAxis);

            // for the vertical grids
            // ==============================================================
        // vis.append("svg:g")
        // 	.attr("class","grid")
        // 	.attr("transform", "translate(" + (margin.left) + "," + (height1 - margin.bottom)+ ")")
        // 	.call(make_x_axis()
        // 			.tickSize(-height1, 0 ,0 )
        // 			.tickFormat("")
        // 		)
        // =====================================================================

        vis.append("svg:g")
            .attr("class","axis")
            .attr("transform", "translate(" + margin.left + ",0)")
            .call(yAxis);

        vis.append("svg:g")
            .attr("class","grid")
            .attr("transform", "translate(" + margin.left + ",0)")
            .call(make_y_axis()
                    .tickSize(-width1,0,0)
                    .tickFormat("")
                )

        var lineGen = d3.svg.line()
                    .x(function (d) {
                        return xScale(d.xValue);
                    })
                    .y(function (d) {
                        return yScale(d.chart2);
                    });

        vis.append('svg:path')
            .attr('d', lineGen(data))
            .attr("transform", "translate(" + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left) + ",0)")
            .attr("stroke", "#ccc")
            .attr("stroke-width", 2)
            .attr("fill", "none");

        vis.selectAll("dot")
            .data(data)
            .enter()
            .append("circle")
            .filter(function (d) {
                return d.chart2;
            })
            .attr("r", 3)
            .attr("fill", "red")
            // .attr("transform", "translate(" + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left) + ",0)")
            .attr("cx", function (d){
                return xScale(d.xValue) + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left);
            })
            .attr("cy", function (d){
                return yScale(d.chart2);
            });

};
