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

$('#select-contractor, #select-contractor-year').change(function () {
    var val = $('#select-contractor').val();
    var dataFor = $('#select-contractor').attr('data-for');
    var param = $('#select-contractor').attr('data');
    var year = $('#select-contractor-year').val();
    var data = {filter: val, type: 'contractor', dataFor: dataFor, param: param, year: year};
    API.get(route, data).success(function (response) {
        $('#barChart-contractors').empty();
        createBarChartProcuring(JSON.parse(response), "barChart-contractors", "contracts/contractor", widthOfParent, val);
    });
});

$('#select-agency, #select-agency-year').change(function () {
    var val = $('#select-agency').val();
    var dataFor = $('#select-agency').attr('data-for');
    var param = $('#select-agency').attr('data');
    var year = $('#select-agency-year').val();
    var data = {filter: val, type: 'agency', dataFor: dataFor, param: param, year: year};
    API.get(route, data).success(function (response) {
        $('#barChart-procuring').empty();
        createBarChartProcuring(JSON.parse(response), "barChart-procuring", "procuring-agency", widthOfParent, val);
    });
});

$('#select-goods, #select-goods-year').change(function () {
    var val = $('#select-goods').val();
    var dataFor = $('#select-goods').attr('data-for');
    var param = $('#select-goods').attr('data');
    var year = $('#select-goods-year').val();
    var data = {filter: val, type: 'goods', dataFor: dataFor, param: param, year: year};
    API.get(route, data).success(function (response) {
        $('#barChart-goods').empty();
        createBarChartProcuring(JSON.parse(response), "barChart-goods", "goods", widthOfParent, val);
    });
});

function validateSubscriberEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function subscribe(){
    var email = $('input[name="email"]').val();
    if(!validateSubscriberEmail(email)){
        $("#subscribeModal").css("display", "block");
        $("#showMsg").html('Invalid email address.');
        return false;
    }
    var csrf = $('input[name="csrf_token"]').val();
    var data = {email: email,csrf_token:csrf};
    API.post(subscribeRoute, data).success(function (response) {
        console.log('true');
        $("#subscribeModal").css("display", "block");
        $("#showMsg").html(response.message);
    }).error(function (error){
        $("#subscribeModal").css("display", "block");
        $("#showMsg").html(error.responseJSON.message);
    });
}

$('#subscribe').click(function () {
    subscribe();
});

$("#subscribe-form").submit(function(e){

    subscribe();

    e.preventDefault();
    return false;
});

