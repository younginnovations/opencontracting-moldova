var createLineChartONHeader = function(data,widthParent,typeColor){
    console.log(typeColor);
    if($(window).width() < 768){
        var height1 = 200;
    }
    else {
        var height1 = 250;
    }
    var divNode = d3.select("#main-content").node();
    var width1 = widthParent;
    var svg = d3.select("#header-linechart")
        .append("svg")
        .attr("width", width1 + 1)
        .attr("height", height1)
        .attr("id", "visualization");
    var vis = d3.select("#visualization"),
        margin = {
            top: 20, right:20, bottom:20, left: 40
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
            .ticks(6)
    }
    function make_y_axis(){
        return d3.svg.axis()
            .scale(yScale)
            .orient("left")
            .ticks(6)
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

    var linePath = vis.append('svg:path')
        .attr('d', lineGen(data))
        .attr("transform", "translate(" + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left) + ",0)")
        .attr("stroke", typeColor)
        .attr("stroke-width", 2)
        .attr("fill", "none");

    var totalLength = linePath.node().getTotalLength();

    linePath
        .attr("stroke-dasharray", totalLength + " " + totalLength)
        .attr("stroke-dashoffset", totalLength)
        .transition()
        .duration(1000)
        .ease("linear")
        .attr("stroke-dashoffset", 0);

    vis.selectAll("dot")
        .data(data)
        .enter()
        .append("circle")
        .filter(function (d) {
            return d.chart2;
        })
        .attr("r", 4)
        .attr("fill", typeColor)
        // .attr("transform", "translate(" + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left) + ",0)")
        .attr("cx", function (d){
            return xScale(d.xValue) + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left);
        })
        .attr("cy", function (d){
            return yScale(d.chart2);
        })
        .on("mouseover", function(d){
            var mousePos = d3.mouse(divNode);
            d3.select("#tooltip-wrap")
                .style("left",mousePos[0] + "px")
                .style("top",mousePos[1] + "px")
                .select("#value")
                .attr("text-anchor","middle")
                .html(d.chart2);

            d3.select("#tooltip-wrap").classed("hide", false);
        })
        .on("mouseout",function(d){
            d3.select("#tooltip-wrap").classed("hide", true);
        });

};
