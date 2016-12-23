function expand() {
    var input = contractData;
    delete input['_id'];

    $('#json-viewer').JSONView(input);
    $('#json-viewer').JSONView('expand');
}
function collapse() {
    var input = contractData;
    delete input['_id'];

    $('#json-viewer').JSONView(input);
    $('#json-viewer').JSONView('collapse');
}

$('#json-viewer').JSONView(input);
$('#json-viewer').JSONView('collapse');

$('.collapser').click(function () {
    console.log('here');
    $('.num').each(function () {
        if ($(this).text() == contractId) {
            console.log($(this).text());
            $(this).closest('.level2').css('background-color', '#eeeeee');
        }
    });
});

var showJsonTable = function () {
    var parent = $("#json-table");
    var table = $('<table>', {
        class: "jTable"
    });
    var count = 1;
    for (var key in input) {
        if (typeof input[key] === 'string') {
            table.append('<tr><td class="main-title" id="title' + count + '" colspan="100%">' + key + '</td><td>' + input[key] + '</td></tr>');
        } else {
            table.append('<tr><td class="main-title" id="title' + count + '" colspan="100%">' + key + '</td></tr>');
            showArray(table, input[key], 1);
        }
        count++;
    }
    parent.append(table);
}

var showArray = function (table, arr, level) {
    for (var a in arr) {
        if (typeof arr[a] != 'object') {
            var tr = '<tr><td class="level-' + level + '">' + a + '</td><td>' + arr[a] + '</td></tr>';
            table.append(tr);
        } else {
            table.append('<tr><td class="level-' + level + '" colspan="100%">' + a + '</td></tr>');
            level = parseInt(level) + 1;
            showArray(table, arr[a], level);
        }

    }
}

showJsonTable();
$(document).ready(function () {
    updateTables();
    //var titleOne, titleTwo, titleThree, titleFour;
    var title =[];

    $('.toggle-switch').click(function (e) {
        var size = Object.keys(input).length;
        for(var z = 1; z <= size; z++){
            title[z] = $('#title' + z).offset().top - 158;
        }

        //titleOne = $('#title1').offset().top - 158, // 76 + 41 + 41 (fixed header + height of td)
        //titleTwo = $('#title2').offset().top - 158,
        //titleThree = $('#title3').offset().top - 158,
        //titleFour = $('#title4').offset().top - 158;
    });

    $(window).scroll(function () {

        $("#json-table").each(function () {
            var el = $(this),
                offset = el.offset(),
                scrollTop = $(window).scrollTop();

            //console.log("element is",el);
            if ((scrollTop > offset.top) && (scrollTop < offset.top + el.height())) {
                fixHeader();
            } else {
                $(".main-title-wrap").each(function () {
                    $("td").removeClass("floatingHeader");
                });
            }
        });
    });

    var calcHeaderWidth = function (element) {
        var tableWidth = $(".jTable").width() - 21;
        element.addClass("floatingHeader");
        element.width(tableWidth);
        element.css('visibility', 'visible');
    }

    var fixHeader = function () {

        var scrollTop = $(window).scrollTop();

        for(var x = 1; x<= title.length-1; x++){
            if (title[x] <= scrollTop && scrollTop < title[x+1]) {
                calcHeaderWidth($("#title"+x));
                $(".main-title").not('[id$="'+ x +'"]').removeClass("floatingHeader");
            }
        }

        //if (titleOne <= scrollTop && scrollTop < titleTwo) {
        //    calcHeaderWidth($("#title1"));
        //    $(".main-title").not('[id$="1"]').removeClass("floatingHeader");
        //
        //} else if (titleTwo <= scrollTop && scrollTop < titleThree) {
        //    calcHeaderWidth($("#title2"));
        //    $(".main-title").not('[id$="2"]').removeClass("floatingHeader");
        //
        //} else if (titleThree <= scrollTop && scrollTop < titleFour) {
        //    calcHeaderWidth($("#title3"));
        //    $(".main-title").not('[id$="3"]').removeClass("floatingHeader");
        //
        //} else if (titleFour <= scrollTop) {
        //    calcHeaderWidth($("#title4"));
        //    $(".main-title").not('[id$="4"]').removeClass("floatingHeader");
        //}
    }
});
//Sending Contract Feed back

$(document).ready(function () {
    $('#submit').on('click', function (e) {
        e.preventDefault();
        var _token = $("input[name='_token']").val();
        var id = $('#contract_id').val();
        var title = $('#contract_title').val();
        var name = $('#fullname').val();
        var trimmedName = $.trim(name);
        var email = $('#email').val();
        var message = $('#message').val();
        var trimmedMessage = $.trim(message);
        var atPos = email.indexOf("@");
        var dotPos = email.lastIndexOf(".");

        if (trimmedName == "") {
            $("#ajaxResponse").html(validateName);
            $("#ajaxResponse").css("color", "#BB0505");
            $("#fullname").focus();
            return false;
        }
        if (email == "") {
            $("#ajaxResponse").html(validateEmail);
            $("#ajaxResponse").css("color", "#BB0505");
            $("#email").focus();
            return false;
        }
        if (atPos < 1 || dotPos < atPos + 2 || dotPos + 2 >= email.length) {
            $("#ajaxResponse").html(validateEmail);
            $("#ajaxResponse").css("color", "#BB0505");
            $("#email").css("border", "1px solid #BB0303");
            return false;
        }
        if (trimmedMessage == "") {
            $("#ajaxResponse").html(validateMessage);
            $("#ajaxResponse").css("color", "#BB0505");
            $("#message").focus();
            return false;
        }
        var g_recaptcha_response = $("#g-recaptcha-response").val();//grecaptcha.getResponse();
        var data = {
            _token: _token,
            id: id,
            title: title,
            fullname: name,
            email: email,
            message: message,
            'g-recaptcha-response': g_recaptcha_response
        };
        $.ajax({
            type: "POST",
            url: route,
            data: data,
            success: function (data) {
                if (data.status != "success") {
                    $("#ajaxResponse").html(data.msg);
                    $("#ajaxResponse").css("color", "#BB0505");
                    return false;
                }
                else {
                    $("#ajaxResponse").html(successMessage);
                    $("#ajaxResponse").css("color", "#04692A");
                    setTimeout(function () {
                        $("#myModal").hide();
                        $('#fullname').val("");
                        $("#ajaxResponse").empty();
                        $("#ajaxResponse").css("color", "#04692A");
                        $('#email').val('');
                        $("#email").css("border", "1px solid #bbb");
                        $("#email").css("background", "#fff");
                        $('#message').val('');
                        grecaptcha.reset();
                    }, 3000);

                }
            }
        });
    });
});
//# sourceMappingURL=contracts.js.map
