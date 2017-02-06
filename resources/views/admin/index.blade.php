@extends('app')

@section('content')
    <div class="block header-block header-with-bg block-header--small">
        <div class="row header-with-icon">
            <h2>@lang('general.contracts_with_comments')</h2>
        </div>
    </div>

    <div class="row table-wrapper ">
        <table id="table_id" class="responsive hover custom-table persist-area">
            <thead class="persist-header">
            <th class="hide">Item ID</th>
            <th>Comment</th>
            <th>Commented BY</th>
            <th>Commented On</th>
            <th>Action</th>
            <th class="hide">ID</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


@endsection
@section('script')
    <script>
        var makeTable = $('#table_id').DataTable({
            "language": {
                'searchPlaceholder': "@lang('agency.search_by_procuring_agency_name')",
                "lengthMenu": "Show _MENU_ comments"
            },
            "bFilter": false,
            "processing": true,
            "serverSide": true,
            "ajax": '/api/comments',
//            "ajaxDataProp": '',
            "columns": [
                {'data': 'item_id', "className": 'hide'},
                {'data': 'comment', "orderable": false, "cursor": "pointer"},
                {'data': 'user_name', "orderable": false},
                {'data': 'created_at', "className": "dt"},
                {'data': 'status', "orderable": false},
                {'data': '_id', "className": 'hide', "orderable": false}
            ],
            "fnDrawCallback": function () {
                createLinks();
                changeDateFormat();
            }
        });
        var createLinks = function () {

            $('#table_id tbody tr').each(function () {
                //For link to the contract which it has comment.
                $(this).find("td:nth-child(2)").css('cursor', 'pointer');
                $(this).find("td:nth-child(5)").css('cursor', 'pointer');
                $(this).find("td:nth-child(2)").click(function () {
                    var contractID = $(this).parent().find("td:first").text();
                    return window.open(window.location.origin + "/contracts/" + contractID, '_blank');
                });

                //link to show/hide comment from the contract page.
                var status = $(this).find("td:nth-child(5)").text();
                $(this).find("td:nth-child(5)").text(status === 'true'? 'Hide Comment' : 'Show Comment');

                $(this).find("td:nth-child(5)").click(function () {
                    var commentID = $(this).parent().find("td:last").text();
                    var commentStatus = ($(this).text() === 'Hide Comment') ? 'hide' : 'show';
                    var button = $(this);
                    $.post(window.location.origin + "/comment/showHide", {
                        commentID: commentID,
                        status: commentStatus
                    }, function (result) {
                        button.text(result === 'hide'? 'Hide Comment' : 'Show Comment');
                    });
                });
            });
        };
    </script>
@endsection
