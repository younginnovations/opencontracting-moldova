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

    console.log("test");
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
        .attr("width",0)
        .transition()
        .duration(900)
        .ease("linear")
        .attr("width", function (d) {
            return x(d.value);
        })
        .attr("x",170);

    chart.selectAll("text.value")
        .data(data)
        .enter()
        .append("text")
        .text(function (d) {
            if(type === 'amount') {
                return d3.format(",")(Math.round(d.value)) + ' MDL';
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
        .attr("dy", barHeight + y1)
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



