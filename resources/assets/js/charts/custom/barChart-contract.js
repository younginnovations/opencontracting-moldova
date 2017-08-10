    var createBarChartContract = function (data, definedId, url) {
    if($(window).width() < 768){
        var heightContainer = 200;
    }
    else {
        var heightContainer = 300;
    }

    console.log("test");
    
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
