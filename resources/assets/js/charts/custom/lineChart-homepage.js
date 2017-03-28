var createLineChart = function (data, parentWidth) {

    if ($(window).width() < 768) {
        var height = 200;
    }
    else {
        var height = 300;
    }

    //fix for error on lineChart with single data
    if(data.length == 1){
        data.push(data[0]) ;
    }

    var divNode = d3.select("#main-content").node(),
        width = parentWidth;
    var svg = d3.select("#linechart-homepage")
        .append("svg")
        .attr("width", width + 1)
        .attr("height", height)
        .attr("id", "visualization");
    var vis = d3.select("#visualization"),
        margin = {
            top: 20, right: 20, bottom: 20, left: 50
        };

    var xScale = d3.scale.ordinal().rangeRoundBands([0, width - 50], 0);
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

    //function make_x_axis(){
    //    return d3.svg.axis()
    //            .scale(xScale)
    //            .orient("bottom")
    //            .ticks(5)
    //}
    function make_y_axis() {
        return d3.svg.axis()
            .scale(yScale)
            .orient("left")
            .ticks(5)
    }

    data.forEach(function (d) {
        d.xValue = d.xValue;
        d.chart1 = +d.chart1;
        d.chart2 = +d.chart2;
    });
    var maxValue = d3.max(data, function (d) {
        return (d.chart1 > d.chart2) ? d.chart1 : d.chart2;
    });

    xScale.domain(data.map(function (d) {
        return d.xValue;
    }));
    yScale.domain([0, maxValue]);


    vis.append("svg:g")
        .attr("class", "axis")
        .attr("transform", "translate(" + (margin.left) + "," + (height - margin.bottom) + ")")
        .call(xAxis);

    // vis.append("svg:g")
    // 	.attr("class","grid")
    // 	.attr("transform", "translate(" + (margin.left) + "," + (height - margin.bottom)+ ")")
    // 	.call(make_x_axis()
    // 			.tickSize(-height+margin.top, 0 ,0 )
    // 			.tickFormat("")
    // 		)
    vis.append("svg:g")
        .attr("class", "axis")
        .attr("transform", "translate(" + margin.left + ",0)")
        .call(yAxis);

    vis.append("svg:g")
        .attr("class", "grid")
        .attr("transform", "translate(" + margin.left + ",0)")
        .call(make_y_axis()
            .tickSize(-width, 0, 0)
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
    var linePath1 = vis.append('svg:path')
        .attr('d', lineGen1(data))
        .attr("transform", "translate(" + (((xScale(data[0].xValue) + xScale(data[1].xValue)) / 2) + margin.left) + ",0)")
        .attr("stroke", "#B8E986")
        .attr("stroke-width", 2)
        .attr("fill", "none");

    var totalLength1 = linePath1.node().getTotalLength();

    linePath1
        .attr("stroke-dasharray", totalLength1 + " " + totalLength1)
        .attr("stroke-dashoffset", totalLength1)
        .transition()
        .duration(1000)
        .ease("linear")
        .attr("stroke-dashoffset", 0);

    var lineGen2 = d3.svg.line()
        .x(function (d) {
            return xScale(d.xValue);
        })
        .y(function (d) {
            return yScale(d.chart2);
        });

    var linePath2 = vis.append('svg:path')
        .attr('d', lineGen2(data))
        .attr("transform", "translate(" + (((xScale(data[0].xValue) + xScale(data[1].xValue)) / 2) + margin.left) + ",0)")
        .attr("stroke", "#50E3C2")
        .attr("stroke-width", 2)
        .attr("fill", "none");

    var totalLength2 = linePath2.node().getTotalLength();

    linePath2
        .attr("stroke-dasharray", totalLength2 + " " + totalLength2)
        .attr("stroke-dashoffset", totalLength2)
        .transition()
        .duration(1000)
        .ease("linear")
        .attr("stroke-dashoffset", 0);

    vis.selectAll("dot")
        .data(data)
        .enter()
        .append("circle")
        .filter(function (d) {
            return d.chart1;
        })
        .attr("r", 4)
        .attr("fill", "#B8E986")
        .attr("cx", function (d) {
            return xScale(d.xValue) + (((xScale(data[0].xValue) + xScale(data[1].xValue)) / 2) + margin.left);
        })
        .attr("cy", function (d) {
            return yScale(d.chart1);
        })
        .on("mouseover", function (d) {
            var mousePos = d3.mouse(divNode);
            d3.select("#tooltip-wrap")
                .style("left", mousePos[0] + "px")
                .style("top", mousePos[1] + "px")
                .select("#value")
                .attr("text-anchor", "middle")
                .html(d.chart1);

            d3.select("#tooltip-wrap").classed("hide", false);
        })
        .on("mouseout", function (d) {
            d3.select("#tooltip-wrap").classed("hide", true);
        });

    vis.selectAll("dot")
        .data(data)
        .enter()
        .append("circle")
        .filter(function (d) {
            return d.chart2;
        })
        .attr("r", 4)
        .attr("fill", "#50E3C2")
        .attr("cx", function (d) {
            return xScale(d.xValue) + (((xScale(data[0].xValue) + xScale(data[1].xValue)) / 2) + margin.left);
        })
        .attr("cy", function (d) {
            return yScale(d.chart2);
        })
        .on("mouseover", function (d) {
            var mousePos = d3.mouse(divNode);
            d3.select("#tooltip-wrap")
                .style("left", mousePos[0] + "px")
                .style("top", mousePos[1] + "px")
                .select("#value")
                .attr("text-anchor", "middle")
                .html(d.chart2);

            d3.select("#tooltip-wrap").classed("hide", false);
        })
        .on("mouseout", function (d) {
            d3.select("#tooltip-wrap").classed("hide", true);
        });

};

// Calling the function that creates the linechart
//createLineChart(data);
