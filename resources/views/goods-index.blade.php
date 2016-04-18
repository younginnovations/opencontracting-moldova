@extends('app')

@section('content')
    <div class="block header-block">
        <div class="row header-with-icon">
            <span><img src="{{url('images/ic_goods.png')}}"/></span>

            <h2>Goods and services</h2>
        </div>
    </div>

    <div class="row table-wrapper">
        <table id="table_id" class="hover custom-table display">
            <thead>
            <tr>
                <th>Name</th>
                <th>CPV code</th>
                <th>Unit</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script>
        $('#table_id').DataTable({
            "language": {
                'searchPlaceholder': "Search by tender title",
                "lengthMenu": "Show _MENU_ Tenders"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '/api/goods',
            "ajaxDataProp": '',
            "pagingType": "full_numbers",
            "columns": [
                {'data': '_id'},
                {'data': 'cpv_value[0]'},
                {'data': 'unit.0'}
            ],
            "fnDrawCallback": function () {
                createLinks();
                if ($('#table_id tr').length < 10) {
                    $('.dataTables_paginate').hide();
                } else {
                    $('.dataTables_paginate').show();
                }
            }
        });

        var createLinks = function () {

            $('#table_id tbody tr').each(function () {
                $(this).css('cursor', 'pointer');
                $(this).click(function () {
                    var goodName = $(this).find("td:first").text();
                    return window.location.assign(window.location.origin + "/goods/" + goodName);
                });

            });
        };

    </script>
@endsection