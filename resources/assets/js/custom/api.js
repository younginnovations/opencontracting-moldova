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

$('#select-contractor').change(function () {
    var val = $(this).val();
    var dataFor = $(this).attr('data-for');
    var param = $(this).attr('data');
    var data = {filter: val, type: 'contractor', dataFor: dataFor, param: param};
    API.get(route, data).success(function (response) {
        $('#barChart-contractors').empty();
        createBarChartProcuring(JSON.parse(response), "barChart-contractors", "contractor");
    });
});

$('#select-agency').change(function () {
    var val = $(this).val();
    var dataFor = $(this).attr('data-for');
    var param = $(this).attr('data');
    var data = {filter: val, type: 'agency', dataFor: dataFor, param: param};
    API.get(route, data).success(function (response) {
        $('#barChart-procuring').empty();
        createBarChartProcuring(JSON.parse(response), "barChart-procuring", "procuring-agency");
    });
});

$('#select-goods').change(function () {
    var val = $(this).val();
    var dataFor = $(this).attr('data-for');
    var param = $(this).attr('data');
    var data = {filter: val, type: 'goods', dataFor: dataFor, param: param};
    API.get(route, data).success(function (response) {
        $('#barChart-goods').empty();
        createBarChartProcuring(JSON.parse(response), "barChart-goods", "goods");
    });
});
