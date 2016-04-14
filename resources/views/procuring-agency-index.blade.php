@extends('app')

@section('content')
    <div class="block header-block header-with-bg">
        <div class="row header-with-icon ">
            <span><img src="{{url('images/ic_procuring-agency.png')}}"/></span>
            <h2>Procuring Agencies</h2>
        </div>
    </div>

    <div class="row table-wrapper">
        <table id="table_id" class="hover custom-table display">
            <thead>
            <tr>
                <th>Procuring Agency Title</th>
                <th>Tenders</th>
                <th>Contracts</th>
                <th>Contract value</th>
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
                'searchPlaceholder': "Search by procuring agency name",
                "lengthMenu": "Show _MENU_ Procuring agency"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '/api/procuring-agency',
            "ajaxDataProp": '',
            "columns": [
                {'data': 'buyer'},
                {'data': 'tender'},
                {'data': 'contract'},
                {'data': 'contract_value'},
            ],
            "fnDrawCallback": function () {
                createLinks();
                if ($('#table_id tr').length < 11) {
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
                    var agencyId = $(this).find("td:first").text();
                    return window.location.assign(window.location.origin + "/procuring-agency/" + agencyId);
                });

            });
        };

    </script>

@endsection