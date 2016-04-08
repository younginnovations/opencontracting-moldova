@extends('app')

@section('content')
    <div class="block header-block">
        <div class="row header-with-icon">
            <span><img src="{{url('images/ic_relatedtender.png')}}"/></span>

            <h2>Tenders</h2>
        </div>
    </div>

    <div class="row table-wrapper">
        <table id="table_id" class="hover custom-table display">
            <thead>
            <tr>
                <th>Tender ID</th>
                <th>Tender Title</th>
                <th>Tender Status</th>
                <th>Procuring Agency</th>
                <th>Tender start date</th>
                <th>Tender end date</th>
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
            "ajax": '/api/tenders',
            "ajaxDataProp": '',
            "pagingType": "full_numbers",
            "columns": [
                {'data': 'tender.id'},
                {'data': 'tender.title'},
                {'data': 'tender.status'},
                {'data': 'tender.procuringAgency.name'},
                {'data': 'tender.tenderPeriod.startDate', 'className': 'dt'},
                {'data': 'tender.tenderPeriod.endDate', 'className': 'dt'},
            ],
            "fnDrawCallback": function () {
                changeDateFormat();
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
                    var tenderId = $(this).find("td:first").text();
                    return window.location.assign(window.location.origin + "/tenders/" + tenderId);
                });

            });
        };

        //        $(document).ready(function () {
        //            $('#table_id tbody tr').click(function () {
        //                window.location = $(this).attr('href');
        //                return false;
        //            });
        //        });
    </script>
    {{--<style>--}}
    {{--table tr {--}}
    {{--cursor: pointer;--}}
    {{--}--}}
    {{--</style>--}}
@endsection