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
    var val = $(this).val();
    var dataFor = $(this).attr('data-for');
    var param = $(this).attr('data');
    var data = {filter: val, type: 'contractor', dataFor: dataFor, param: param};
    API.get(route, data).success(function (response) {
        $('#barChart-contractors').empty();
        createBarChartProcuring(JSON.parse(response), "barChart-contractors", "contracts/contractor", widthOfParent, val);
    });
});

$('#select-agency').change(function () {
    var val = $(this).val();
    var dataFor = $(this).attr('data-for');
    var param = $(this).attr('data');
    var data = {filter: val, type: 'agency', dataFor: dataFor, param: param};
    API.get(route, data).success(function (response) {
        $('#barChart-procuring').empty();
        createBarChartProcuring(JSON.parse(response), "barChart-procuring", "procuring-agency", widthOfParent, val);
    });
});

$('#select-goods').change(function () {
    var val = $(this).val();
    var dataFor = $(this).attr('data-for');
    var param = $(this).attr('data');
    var data = {filter: val, type: 'goods', dataFor: dataFor, param: param};
    API.get(route, data).success(function (response) {
        $('#barChart-goods').empty();
        createBarChartProcuring(JSON.parse(response), "barChart-goods", "goods", widthOfParent, val);
    });
});

$('#subscribe').click(function () {
    var email = $('input[name="email"]').val();
    var data = {email: email};
    API.post(subscribeRoute, data).success(function (response) {
        $("#subscribeModal").css("display","block");
        if(response == "true"){
            $("#showMsg").html('Thank you for subscribing.')
        }else{
            $("#showMsg").html('This email has already been used.');
        }
    })
});
