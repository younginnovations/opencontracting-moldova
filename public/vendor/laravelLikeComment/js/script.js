$('.laravelLike-icon').on('click', function () {
    if ($(this).hasClass('disabled'))
        return false;

    var item_id = $(this).data('item-id');
    var vote = $(this).data('vote');

    $.ajax({
            method: "get",
            url: "/comments/like/vote",
            data: {item_id: item_id, vote: vote},
            dataType: "json"
        })
        .done(function (msg) {
            if (msg.flag == 1) {
                if (msg.vote == 1) {
                    $('#' + item_id + '-like').removeClass('outline');
                    $('#' + item_id + '-dislike').addClass('outline');
                }
                else if (msg.vote == -1) {
                    $('#' + item_id + '-dislike').removeClass('outline');
                    $('#' + item_id + '-like').addClass('outline');
                }
                else if (msg.vote == 0) {
                    $('#' + item_id + '-like').addClass('outline');
                    $('#' + item_id + '-dislike').addClass('outline');
                }
                $('#' + item_id + '-total-like').text(msg.totalLike == null ? 0 : msg.totalLike);
                $('#' + item_id + '-total-dislike').text(msg.totalDislike == null ? 0 : msg.totalDislike);
            }
        })
        .fail(function (msg) {
            alert(msg);
        });
});


$(document).on('click', '.reply-button', function () {
    if ($(this).hasClass("disabled"))
        return false;
    var toggle = $(this).data('toggle');
    $("#" + toggle).fadeToggle('normal');
});

$(document).on('submit', '.laravelComment-form', function () {
    var thisForm = $(this);
    var parent = $(this).data('parent');
    var item_id = $(this).data('item');
    var comment = $('textarea#' + parent + '-textarea').val();

    $.ajax({
            method: "get",
            url: "/comments/comment/add",
            data: {parent: parent, comment: comment, item_id: item_id},
            dataType: "json"
        })
        .done(function (msg) {
            $(thisForm).toggle('normal');
            $('.box-comment').css('display', 'none');
            var newComment = '<div class="comment show-' + item_id + '-' + parent + '" id="comment-' + msg.id + '" style="display: block;"><a class="avatar"><img src="' + msg.userPic + '"></a><div class="content"><a class="author">' + msg.userName + '</a><div class="metadata"><span class="date">Today at 5:42PM</span></div><div class="text">' + msg.comment + '</div><div class="actions"><a class="reply reply-button" data-toggle="' + msg.id + '-reply-form">Reply</a></div><form class="ui laravelComment-form form" id="' + msg.id + '-reply-form" data-parent="' + msg.id + '" data-item="' + item_id + '" style="display: none;"><div class="field"><textarea id="' + msg.id + '-textarea" rows="2"></textarea></div><input type="submit" class="ui basic small submit button" value="Reply"></form></div><div class="ui threaded comments" id="' + item_id + '-comment-' + msg.id + '"></div></div>';
            $('#' + item_id + '-comment-' + parent).prepend(newComment);
            $('textarea#' + parent + '-textarea').val('');
            autosize($('.laravelComment textarea'));
        })
        .fail(function (msg) {
            alert(msg);
        });

    return false;
});

window.onload = function(){
    var url = window.location.href;
    var value = url.substring(url.lastIndexOf('/') + 1);
   $(".show-" + value + "-0").fadeIn('normal');
};

$(document).on('click', '#showComment', function () {
    var show = $(this).data("show-comment");
    show = (show == 0)?show+1:show;
    $('.show-' + $(this).data("item-id") + '-' + show).fadeIn('normal');
    $(this).data("show-comment", show + 1);
    if(show > (commentCount/5)){
        $(this).addClass('hide');
    }
    $(this).text("Show more comments");
});
