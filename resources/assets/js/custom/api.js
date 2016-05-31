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

$('#subscribe').click(function () {
    var email = $('input[name="email"]').val();
    var data = {email: email};
    API.post(subscribeRoute, data).success(function (response) {
        $("#subscribeModal").css("display", "block");
        if (response == "true") {
            $("#showMsg").html('Thank you for subscribing.')
        } else {
            $("#showMsg").html('This email has already been used.');
        }
    })
});
