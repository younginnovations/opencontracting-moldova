var createLineChart = function(data,parentWidth){

    if($(window).width() < 768){
        var height = 200;
    }
    else {
        var height = 300;
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

    //function make_x_axis(){
    //    return d3.svg.axis()
    //            .scale(xScale)
    //            .orient("bottom")
    //            .ticks(5)
    //}
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
        var linePath1 = vis.append('svg:path')
            .attr('d', lineGen1(data))
            .attr("transform", "translate(" + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left) + ",0)")
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
            .attr("transform", "translate(" + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left) + ",0)")
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
            .attr("cx", function (d){
                return xScale(d.xValue) + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left);
            })
            .attr("cy", function (d){
                return yScale(d.chart1);
            })
        .on("mouseover", function(d){
            var mousePos = d3.mouse(divNode);
            d3.select("#tooltip-wrap")
                .style("left",mousePos[0] + "px")
                .style("top",mousePos[1] + "px")
                .select("#value")
                .attr("text-anchor","middle")
                .html(d.chart1);

            d3.select("#tooltip-wrap").classed("hide", false);
        })
        .on("mouseout",function(d){
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

// Calling the function that creates the linechart
//createLineChart(data);

var createLineChartRest = function(data,widthParent){
    if($(window).width() < 768){
        var height1 = 200;
    }
    else {
        var height1 = 300;
    }
    var divNode = d3.select("#main-content").node();
    var width1 = widthParent;
    var svg = d3.select("#linechart-rest")
                .append("svg")
                .attr("width", width1 + 1)
                .attr("height", height1)
                .attr("id", "visualization");
    var vis = d3.select("#visualization"),
                margin = {
                    top: 20, right:20, bottom:20, left: 34
                };
    var xScale = d3.scale.ordinal().rangeRoundBands([0,width1-50], 0);
    var xDot = d3.scale.ordinal().rangeRoundBands([0, width1], 1.07);
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
        var maxValue = d3.max(data, function(d){
            return d.chart2; });
        xScale.domain(data.map(function (d) {return d.xValue; }));
        xDot.domain(data.map(function (d) {return d.xValue; }));
        yScale.domain([0,maxValue]);

        vis.append("svg:g")
            .attr("class","axis")
            .attr("transform", "translate(" + (margin.left) + "," + (height1 - margin.bottom)+ ")")
            .call(xAxis);

            // for the vertical grids
            // ==============================================================
         //vis.append("svg:g")
         //	.attr("class","grid")
         //	.attr("transform", "translate(" + (margin.left) + "," + (height1 - margin.bottom)+ ")")
         //	.call(make_x_axis()
         //			.tickSize(-height1, 0 ,0 )
         //			.tickFormat("")
         //		);
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
                );

        var lineGen = d3.svg.line()
                    .x(function (d) {
                        return xScale(d.xValue);
                    })
                    .y(function (d) {
                        return yScale(d.chart2);
                    });
    if(data.length > 1){
        var linePath = vis.append('svg:path')
            .attr('d', lineGen(data))
            .attr("transform", "translate(" + (((xScale(data[0].xValue)+xScale(data[1].xValue))/2) + margin.left) + ",0)")
            .attr("stroke", "#B8E986")
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
            .attr("fill", "#B8E986")
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
    }
    else if(data.length ===1){
        vis.selectAll("dot")
            .data(data)
            .enter()
            .append("circle")
            .filter(function (d) {
                return d.chart2;
            })
            .attr("r", 4)
            .attr("fill", "#B8E986")
            .attr("cx", function (d){
                return xDot(d.xValue);
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
    }
    else{
        vis.selectAll("dot")
            .data(data)
            .enter()
            .append("circle")
            .filter(function (d) {
                return d.chart2;
            })
            .attr("r", 4)
            .attr("fill", "#B8E986")
            .attr("cx", function (d){
                return xDot(d.xValue);
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
    }
};

var createBarChartProcuring = function (data, definedId, url, widthParent, type) {
    if($(window).width() < 768){
        var marginBottom = 12,
            barHeight = 37,
            y1 = 21;
    }
    else {

        var marginBottom = 20,
            barHeight = 55,
            y1 = 32;
    }


    //var divNode = d3.select("#main-content").node();

    var dataRange = d3.max(data, function (d) {
        return d.value;
    });
    var divId = "#" + definedId;
    var width = widthParent;
    var chart,
        height = barHeight * data.length;
    var x, y;
    var bodyNode = d3.select("#main").node();

    $(divId).html('');
    chart = d3.select(divId)
        .append("svg")
        .attr("class", "chart")
        .attr("width", width)
        .attr("height", height);

    x = d3.scale.linear()
        .domain([0, dataRange])
        .range([0, width - 151]);
    y = d3.scale.ordinal()
        .rangeBands([0, height]);

    chart.selectAll("rect")
        .data(data)
        .enter()
        .append("rect")
        .attr("x", 170)
        .attr("y", function (d, i) {
            return i * (height / data.length);
        })
        .attr("class", function(d){
            if(d.name !== null) {
                return "name";
            }
        })
        .attr("height", barHeight - marginBottom)
        .on("click", function (d) {
            if(d.name !== null) {
                return window.location.assign(window.location.origin + "/" + url + "/" + d.name);
            }
        })
        /*.on("mouseover", function(d){
            var mousePos = d3.mouse(divNode);
            d3.select("#tooltip-wrap")
                .style("left",mousePos[0] + "px")
                .style("top",mousePos[1] + "px")
                .select("#value")
                .attr("text-anchor","middle")
                .html(d.value);

            d3.select("#tooltip-wrap").classed("hide", false);
        })
        .on("mouseout",function(d){
            d3.select("#tooltip-wrap").classed("hide", true);
        })*/
        .attr("width",0)
        .transition()
        .duration(900)
        .ease("linear")
        .attr("width", function (d) {
            return x(d.value);
        })
        .attr("x",170);

    //    .on("mousemove",function(d){
    //         var absoluteMousePos = d3.mouse(bodyNode);
    //         d3.select("#tooltip")
    //             .style("left", absoluteMousePos[0] + "px")
    //             .style("top", absoluteMousePos[1] + "px")
    //             .select("#name")
    //             .text(d.name);
    //
    //         d3.select("#tooltip").classed("hidden", false);
    //     })
    //     .on("mouseout",function(){
    //         d3.select("#tooltip").classed("hidden", true);
    //     });

    chart.selectAll("text.value")
        .data(data)
        .enter()
        .append("text")
        .text(function (d) {
            if(type === 'amount') {
                return d3.format(",")(Math.round(d.value)) + ' leu';
            }else{
                return d3.format(",")(Math.round(d.value));
            }
        })
        .attr("y", function (d, i) {
            return i * (height / data.length);
        })
        .attr("dx", 173)
        .attr("dy", barHeight - y1)
        .attr("class","value")
        .on("click", function (d) {
            if(d.name !== null) {
                return window.location.assign(window.location.origin + "/" + url + "/" + d.name);
            }
        })
        .attr("id", function (d, i) {
            return d.name;
        });
    chart.selectAll("text.name")
        .data(data)
        .enter()
        .append("text")
        .text(function (d) {
            if ((d.name) != null) {
                if ((d.name).length > 20) {
                    return (String(d.name).slice(0, 21) + "...");
                }
                else {
                    return (String(d.name).slice(0, 21));
                }
            }
            else {
                return ('N/A');
            }
        })
        .attr("y", function (d, i) {
            return i * (height / data.length);
        })
        .attr("dx", 0)
        .attr("dy", barHeight - y1)
        .attr("class", function(d){
            if(d.name !== null) {
                return "name";
            }
        })
        .on("click", function (d) {
            if(d.name !== null) {
                return window.location.assign(window.location.origin + "/" + url + "/" + d.name);
            }
        })
        .attr("id", function (d, i) {
            return d.name;
        });
};




    var createBarChartContract = function (data, definedId, url) {
    if($(window).width() < 768){
        var heightContainer = 200;
    }
    else {
        var heightContainer = 300;
    }

    var divNode = d3.select("#main-content").node();
    var divId = "#" + definedId;
    var widthOfParent = $(divId).parent().width();
    var margin = {top: 20, right: 20, bottom: 20, left: 100},
        width = widthOfParent - margin.left - margin.right,
        height = heightContainer - margin.top - margin.bottom;

    var x = d3.scale.ordinal().rangeRoundBands([0, width], .35);

    var y = d3.scale.linear().range([height, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        .ticks(5);

    var svg = d3.select("#barChart-amount").append("svg")
        .attr("width", width + margin.left + 1)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");

    data.forEach(function(d) {
        d.name = d.name;
        d.value = +d.value;
    });

    x.domain(data.map(function(d) { return d.name; }));
    y.domain([0, d3.max(data, function(d) { return d.value; })]);

    function make_y_axis(){
        return d3.svg.axis()
            .scale(y)
            .orient("left")
            .ticks(5)
    }

    svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis)

        .selectAll("text")
        .style("text-anchor", "end")
        .attr("dx", "1em")
        .attr("dy", ".75em");

    svg.append("g")
        .attr("class", "y axis")
        .call(yAxis)
        .append("text")
        .attr("y", 6)
        .attr("dy", ".71em");

    svg.append("svg:g")
        .attr("class","grid")
        .attr("transform", "translate(0,0)")
        .call(make_y_axis()
            .tickSize(-width,0,0)
            .tickFormat("")
        )


  /*  // chart title

    svg.selectAll("text.bar")
        .data(data)
        .enter().append("text")
        .attr("class", "verticalBar-value numeric-data")
        .attr("text-anchor", "middle")
        .attr("x", function(d) { return x(d.name) + x.rangeBand()/2; })
        .attr("y", function(d) { return y(d.value) - 5; })
        .html(function(d) { return d.value; });*/

    svg.selectAll("bar")
        .data(data)
        .enter().append("rect")
        .attr("class","bars")
        .attr("x", function(d) {
            return x(d.name); })
        .attr("width", x.rangeBand())
            .attr("y", height)
            .attr("height", 0)
            .transition()
            .duration(900)
            .ease("linear")
        .attr("y", function(d){
            return y(d.value)})
        .attr("height", function(d) {
            if(d.value < 0)
                return height - y(0);
            else
            return height - y(d.value); });

    svg.selectAll("rect")
        .on("mousemove", function(d){
            var mousePos = d3.mouse(divNode);
            d3.select("#tooltip-no-tip")
                .style("left",mousePos[0] + "px")
                .style("top",mousePos[1] + "px")
                .select("#value")
                .attr("text-anchor","middle")
                .html(d.value);

            d3.select("#tooltip-no-tip").classed("hide", false);
        })
        .on("mouseout",function(d){
            d3.select("#tooltip-no-tip").classed("hide", true);
        });

};

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

//# sourceMappingURL=customChart.js.map
