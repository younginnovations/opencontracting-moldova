var createSlider = function (route, type, widthOfParent, definedId, url, element) {
    var formatDate = d3.time.format("%Y");
    var customFormat = d3.time.format("%Y%m");
    var cValue = 0;
    var flag = 0;
    var insetValue1, insetValue2;
// parameters
    var margin = {
            top: 20,
            right: 20,
            bottom: 20,
            left: 20
        },
        width = widthOfParent - margin.left - margin.right,
        height = 70 - margin.bottom - margin.top;

// scale function
    var timeScale = d3.time.scale()
        .domain([new Date('2012-01-01 '), new Date('2017-12-30')])
        .range([0, width])
        .clamp(true);
    var axistimeScale = d3.time.scale()
        .domain([new Date('2011-01-01'), new Date('2017-01-01')])
        .range([0, width])
        .clamp(true);


// initial value
// var startValue = timeScale(new Date('2014-01-10'));
    var startingValue1 = new Date('2017-01-01');
    var startingValue2 = new Date('2017-12-30');

// defines brush
    var brush = d3.svg.brush()
        .x(timeScale)
        // .extent([startingValue1, startingValue2])
        .on("brush", brushed)
        .on("brushend", brushend);

    var svg = d3.select(element).append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height / 2 + ")")
        .call(d3.svg.axis()
            .scale(axistimeScale)
            .orient("bottom")
            .tickFormat(function (d) {
                return formatDate(d);
            })
            .tickSize(10)
            .tickPadding(0)
        )
        .selectAll("text")
        .attr("x", -width / 12)

    var slider = svg.append("g")
        .attr("transform", "translate(0,10)")
        .attr("class", "slider")
        .call(brush)

    slider.selectAll(".extent,.resize").remove();

// call(brush) generates <rect class="background"> on slider. (see DOM in inspect element)
// slider pointer (crosshair)
    slider.select(".background")
        .attr("height", height / 2)
        .style("fill", "white")
    // .style("visibility","visible");

// slider white line
    d3.select(element + " .slider")
        .insert("line", "rect.background")
        .attr("x1", "0")
        .attr("x2", width)
        .attr("class", "main-line")

    var handle1 = slider.append("g")
        .attr("transform", "translate(0," + (height / 2) + ")")
        .attr("class", "handle1")
    var handle2 = slider.append("g")
        .attr("transform", "translate(0," + (height / 2) + ")")
        .attr("class", "handle2")

    handle1.append("circle")
        .attr("r", "6")
        .attr("class", "slider-circle")

    handle2.append("circle")
        .attr("r", "6")
        .attr("class", "slider-circle")

    var value1 = startingValue1;
    var value2 = startingValue2;

    handle1.attr("transform", "translate(" + timeScale(value1) + ",0)");
    handle2.attr("transform", "translate(" + timeScale(value2) + ",0)");

    slider.call(brush.event)


    function brushed() {

        var calculate = (+customFormat(value1) + +customFormat(value2)) / 2;
        var mouseValue = timeScale.invert(d3.mouse(this)[0]);
        if (customFormat(mouseValue) < calculate) {
            value1 = mouseValue;
            handle1.attr("transform", "translate(" + timeScale(value1) + ",0)");
            handle1.select('text').text(formatDate(value1));
            flag = 1;
        }
        if (customFormat(mouseValue) > calculate) {
            value2 = mouseValue;
            handle2.attr("transform", "translate(" + timeScale(value2) + ",0)");
            handle2.select('text').text(formatDate(value2));
            flag = 2;
        }

        insetValue1 = timeScale(value1);
        insetValue2 = timeScale(value2);

        d3.select(element + " .slider-inset").remove();
        // Initial slider inset
        d3.select(element + " .slider")
            .insert("line", "rect.background")
            .attr("x1", insetValue1)
            .attr("x2", insetValue2)
            .attr("class", "slider-inset")

    }

//
    function brushend() {
        value = timeScale.invert(d3.mouse(this)[0]);
        cValue = customFormat(value);
        // 2012
        if (cValue > 2011 && cValue < 201206) {
            value = new Date('2011-12-30');
            handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
            flag = "handle1";
        }
        else if (cValue >= 201206 && cValue < 201212) {
            value = new Date('2012-12-30');
            handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
            flag = "handle1";

        }
// 2013
        else if (cValue > 2013 && cValue < 201306) {
            value = new Date('2012-12-30');
            if (flag == 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                handle1.select('text').text(formatDate(value));
                flag = "handle1";
            }
            if (flag == 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                handle2.select('text').text(formatDate(value));
                flag = "handle2";
            }
        }
        else if (cValue >= 201306 && cValue <= 201312) {
            value = new Date('2013-12-30');
            if (flag == 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag == 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }

// 2014
        else if (cValue > 201312 && cValue < 201406) {
            value = new Date('2013-12-30');
            if (flag == 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag == 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }
        else if (cValue >= 201406 && cValue <= 201412) {
            value = new Date('2014-12-30');
            if (flag == 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag == 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }

// 2015
        else if (cValue > 201412 && cValue < 201506) {
            value = new Date('2014-12-30');
            if (flag == 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag == 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }
        else if (cValue >= 201506 && cValue <= 201512) {
            value = new Date('2015-12-30');
            if (flag == 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag == 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }

// 2016
        else if (cValue > 201512 && cValue < 201606) {
            value = new Date('2015-12-30');
            if (flag == 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag == 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }
        else if (cValue >= 201606 && cValue <= 201612) {
            value = new Date('2016-12-30');
            if (flag == 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag == 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }

// 2017
        else if (cValue > 201612 && cValue < 201706) {
            value = new Date('2016-12-30');
            if (flag == 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }
        else if (cValue >= 201706 && cValue <= 201712) {
            value = new Date('2017-12-30');
            if (flag == 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }
        // slider inset
        if (flag === "handle1") {
            value1 = value;
            d3.select(element + " .slider-inset").remove();
            d3.select(element + " .slider")
                .insert("line", "rect.background")
                .attr("x1", timeScale(value))
                .attr("x2", insetValue2)
                .attr("class", "slider-inset")
        }
        if (flag === "handle2") {
            value2 = value;
            d3.select(element + " .slider-inset").remove();
            d3.select(element + " .slider")
                .insert("line", "rect.background")
                .attr("x1", insetValue1)
                .attr("x2", timeScale(value))
                .attr("class", "slider-inset")
        }
        var startVal = formatDate(value1);

        if (cValue != '0NaNNaN') {
            startVal = (startVal == 2011) ? 2012 : parseInt(startVal) + 1;
        }

        $("#select-year-" + type).attr('from', startVal);
        $("#select-year-" + type).attr('to', formatDate(value2));

        console.log(startVal+" : "+ formatDate(value2));

        getTrendData(route, type, widthOfParent, definedId, url);
        flag = 0;
    }


};

var only_slider = function (widthOfParent, element) {
    var formatDate = d3.time.format("%Y");
    var customFormat = d3.time.format("%Y%m");
    var cValue = 0;
    var flag = 0;
    var insetValue1, insetValue2;
// parameters
    var margin = {
            top: 20,
            right: 20,
            bottom: 20,
            left: 20
        },
        width = widthOfParent - margin.left - margin.right,
        height = 70 - margin.bottom - margin.top;

// scale function
    var timeScale = d3.time.scale()
        .domain([new Date('2012-01-01 '), new Date('2017-12-30')])
        .range([0, width])
        .clamp(true);
    var axistimeScale = d3.time.scale()
        .domain([new Date('2011-01-01'), new Date('2017-01-01')])
        .range([0, width])
        .clamp(true);


// initial value
// var startValue = timeScale(new Date('2014-01-10'));
    var startingValue1 = new Date('2012-01-01');
    var startingValue2 = new Date('2017-12-30');

// defines brush
    var brush = d3.svg.brush()
        .x(timeScale)
        // .extent([startingValue1, startingValue2])
        .on("brush", brushed)
        .on("brushend", brushend);

    var svg = d3.select(element).append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height / 2 + ")")
        .call(d3.svg.axis()
            .scale(axistimeScale)
            .orient("bottom")
            .tickFormat(function (d) {
                return formatDate(d);
            })
            .tickSize(10)
            .tickPadding(0)
        )
        .selectAll("text")
        .attr("x", -width / 12);

    var slider = svg.append("g")
        .attr("transform", "translate(0,10)")
        .attr("class", "slider")
        .call(brush);

    slider.selectAll(".extent,.resize").remove();

// call(brush) generates <rect class="background"> on slider. (see DOM in inspect element)
// slider pointer (crosshair)
    slider.select(".background")
        .attr("height", height / 2)
        .style("fill", "white");
    // .style("visibility","visible");

// slider white line
    d3.select(element + " .slider")
        .insert("line", "rect.background")
        .attr("x1", "0")
        .attr("x2", width)
        .attr("class", "main-line");

    var handle1 = slider.append("g")
        .attr("transform", "translate(0," + (height / 2) + ")")
        .attr("class", "handle1");
    var handle2 = slider.append("g")
        .attr("transform", "translate(0," + (height / 2) + ")")
        .attr("class", "handle2");

    handle1.append("circle")
        .attr("r", "6")
        .attr("class", "slider-circle");

    handle2.append("circle")
        .attr("r", "6")
        .attr("class", "slider-circle");

    var value1 = startingValue1;
    var value2 = startingValue2;

    handle1.attr("transform", "translate(" + timeScale(value1) + ",0)");
    handle2.attr("transform", "translate(" + timeScale(value2) + ",0)");

    slider.call(brush.event);


    function brushed() {

        var calculate = (+customFormat(value1) + +customFormat(value2)) / 2;
        var mouseValue = timeScale.invert(d3.mouse(this)[0]);
        if (customFormat(mouseValue) < calculate) {
            value1 = mouseValue;
            handle1.attr("transform", "translate(" + timeScale(value1) + ",0)");
            handle1.select('text').text(formatDate(value1));
            flag = 1;
        }
        if (customFormat(mouseValue) > calculate) {
            value2 = mouseValue;
            handle2.attr("transform", "translate(" + timeScale(value2) + ",0)");
            handle2.select('text').text(formatDate(value2));
            flag = 2;
        }

        insetValue1 = timeScale(value1);
        insetValue2 = timeScale(value2);

        d3.select(element + " .slider-inset").remove();
        // Initial slider inset
        d3.select(element + " .slider")
            .insert("line", "rect.background")
            .attr("x1", insetValue1)
            .attr("x2", insetValue2)
            .attr("class", "slider-inset")

    }

//
    function brushend() {
        value = timeScale.invert(d3.mouse(this)[0]);
        cValue = customFormat(value);
        // 2012
        if (cValue > 2011 && cValue < 201206) {
            value = new Date('2011-12-30');
            handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
            flag = "handle1";
        }
        else if (cValue >= 201206 && cValue < 201212) {
            value = new Date('2012-12-30');
            handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
            flag = "handle1";

        }
// 2013
        else if (cValue > 2013 && cValue < 201306) {
            value = new Date('2012-12-30');
            if (flag === 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                handle1.select('text').text(formatDate(value));
                flag = "handle1";
            }
            if (flag === 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                handle2.select('text').text(formatDate(value));
                flag = "handle2";
            }
        }
        else if (cValue >= 201306 && cValue <= 201312) {
            value = new Date('2013-12-30');
            if (flag === 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag === 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }

// 2014
        else if (cValue > 201312 && cValue < 201406) {
            value = new Date('2013-12-30');
            if (flag === 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag === 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }
        else if (cValue >= 201406 && cValue <= 201412) {
            value = new Date('2014-12-30');
            if (flag === 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag === 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }

// 2015
        else if (cValue > 201412 && cValue < 201506) {
            value = new Date('2014-12-30');
            if (flag === 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag === 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }
        else if (cValue >= 201506 && cValue <= 201512) {
            value = new Date('2015-12-30');
            if (flag === 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag === 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }

// 2016
        else if (cValue > 201512 && cValue < 201606) {
            value = new Date('2015-12-30');
            if (flag === 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag === 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }
        else if (cValue >= 201606 && cValue <= 201612) {
            value = new Date('2016-12-30');
            if (flag === 1) {
                handle1.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle1";
            }
            if (flag === 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }

// 2017
        else if (cValue > 201612 && cValue < 201706) {
            value = new Date('2016-12-30');
            if (flag === 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }
        else if (cValue >= 201706 && cValue <= 201712) {
            value = new Date('2017-12-30');
            if (flag === 2) {
                handle2.attr("transform", "translate(" + timeScale(value) + ",0)");
                flag = "handle2";
            }
        }
        // slider inset
        if (flag === "handle1") {
            value1 = value;
            d3.select(element + " .slider-inset").remove();
            d3.select(element + " .slider")
                .insert("line", "rect.background")
                .attr("x1", timeScale(value))
                .attr("x2", insetValue2)
                .attr("class", "slider-inset")
        }
        if (flag === "handle2") {
            value2 = value;
            d3.select(element + " .slider-inset").remove();
            d3.select(element + " .slider")
                .insert("line", "rect.background")
                .attr("x1", insetValue1)
                .attr("x2", timeScale(value))
                .attr("class", "slider-inset")
        }
        var startVal = formatDate(value1);

        if (cValue !== '0NaNNaN') {
            startVal = (startVal === 2011) ? 2012 : parseInt(startVal) + 1;
        }

       // $("#select-year-" + type).attr('from', startVal);
       // $("#select-year-" + type).attr('to', formatDate(value2));

        console.log("Start Value "+startVal+", End value "+ formatDate(value2));
        $("#startDate").val(startVal);
        $("#endDate").val(formatDate(value2));

        flag = 0;
    }


};