var API = {
    post: function (url, data) {
        return $.ajax({
            url: url,
            data: data,
            type: "POST"
        });
    },
    get: function (url, data, async) {
        return $.ajax({
            url: url,
            data: data,
            async: (typeof async === 'undefined') ? true : async,
            type: "GET"
        });
    },
    delete: function (url, data) {
        return $.ajax({
            url: url,
            data: data,
            type: "DELETE"
        });
    }
};

var widthOfParent = $('.chart-wrap').width();

$('#select-contractor').change(function () {
    getTrendData(route, 'contractor', widthOfParent, "barChart-contractors", "contracts/contractor");

});

$('#select-agency').on("change", function () {

    getTrendData(route, 'agency', widthOfParent, "barChart-procuring", "procuring-agency");

});

$('#select-goods').change(function () {

    getTrendData(route, 'goods', widthOfParent, "barChart-goods", "goods");

});


function getTrendData(route, type, widthOfParent, definedId, url) {
    var val = $('#select-' + type).val();
    var dataFor = $('#select-' + type).attr('data-for');
    var param = $('#select-' + type).attr('data');
    var year = $('#select-' + type + '-year').val();

    var from = $("#select-year-" + type).attr('from');
    var to = $("#select-year-" + type).attr('to');

    var data = {filter: val, type: type, dataFor: dataFor, param: param, year: year, from: from, to: to};
    console.log(data);
    API.get(route, data).success(function (response) {
        $('#' + definedId).empty();
        createBarChartProcuring(JSON.parse(response), definedId, url, widthOfParent, val);
    });
}


function validateSubscriberEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function subscribe() {
    var email = $('input[name="email"]').val();
    if (!validateSubscriberEmail(email)) {
        $("#subscribeModal").css("display", "block");
        $("#showMsg").html('Invalid email address.');
        return false;
    }
    var csrf = $('input[name="csrf_token"]').val();
    var data = {email: email, csrf_token: csrf};
    API.post(subscribeRoute, data).success(function (response) {
        console.log('true');
        $("#subscribeModal").css("display", "block");
        $("#showMsg").html(response.message);
    }).error(function (error) {
        $("#subscribeModal").css("display", "block");
        $("#showMsg").html(error.responseJSON.message);
    });
}

$('#subscribe').click(function () {
    subscribe();
});

$("#subscribe-form").submit(function (e) {

    subscribe();

    e.preventDefault();
    return false;
});

