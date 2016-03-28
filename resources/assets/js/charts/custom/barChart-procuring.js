var data1 = [
    {
        "name": "moldocds",
        "value": "1400"
    },
    {
        "name": "moldocds1",
        "value": "1300"
    },
    {
        "name": "moldocds2",
        "value": "1200"
    },
    {
        "name": "moldocds3",
        "value": "1100"
    },
    {
        "name": "moldocds4",
        "value": "1000"
    },
];
var data2 = [
    {
        "name": "ocds",
        "value": "1400"
    },
    {
        "name": "ocds1",
        "value": "1300"
    },
    {
        "name": "ocds2",
        "value": "1200"
    },
    {
        "name": "ocds3",
        "value": "1100"
    },
    {
        "name": "ocds4",
        "value": "1000"
    },
];
var createBarChartProcuring = function (data, definedId, url) {
    var dataRange = d3.max(data, function (d) {
        return d.value;
    });
    var divId = "#" + definedId;
    var widthOfParent = $(divId).parent().width();

    var width = widthOfParent;
    var chart,
        barHeight = 37,
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
        .attr("x", 150)
        .attr("y", function (d, i) {
            return i * (height / data.length);
        })
        .attr("width", function (d) {
            return x(d.value);
        })
        .attr("height", barHeight - 12)
        .on("click", function (d) {
            return window.location.assign(window.location.origin + "/" + url + "/" + d.name);
        })
        .attr("id", function (d, i) {
            return d.name;
        });
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
            return d3.format(",")(Math.round(d.value));
        })
        .attr("y", function (d, i) {
            return i * (height / data.length);
        })
        .attr("dx", 153)
        .attr("dy", barHeight - 21)
        .attr("class", "value")
        .on("click", function (d) {
            return window.location.assign(window.location.origin + "/" + url + "/" + d.name);
        })
        .attr("id", function (d, i) {
            return d.name;
        });
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

    chart.selectAll("text.name")
        .data(data)
        .enter()
        .append("text")
        .text(function (d) {
            if ((d.name) != null) {
                if ((d.name).length > 20) {
                    return (String(d.name).slice(0, 20) + "...");
                }
                else {
                    return (String(d.name).slice(0, 20));
                }
            }
            else {
                return (String(d.name).slice(0, 20));
            }
        })
        .attr("y", function (d, i) {
            return i * (height / data.length);
        })
        .attr("dx", 0)
        .attr("dy", barHeight - 21)
        .attr("class", "name")
        .on("click", function (d) {
            return window.location.assign(window.location.origin + "/" + url + "/" + d.name);
        })
        .attr("id", function (d, i) {
            return d.name;
        });
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
};

//createBarChartProcuring(data1,"barChart-procuring");
//createBarChartProcuring(data2,"barChart-contractors");
//createBarChartProcuring(data2,"barChart-goods");
