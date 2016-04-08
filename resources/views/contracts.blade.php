@extends('app')

@section('content')
    <div class="block header-block  header-with-bg">
        <div class="row header-with-icon">
            <span><img src="{{url('images/ic_contractor.png')}}"/></span>
            <h2>Contracts</h2>
        </div>
    </div>

    <div class="row table-wrapper">
        <table id="table_id" class="responsive hover custom-table display">
            <thead>
            <tr>
                <th>Contract number</th>
                <th class="hide">Contract ID</th>
                <th>Goods and services contracted</th>
                <th width="150px">Contract start date</th>
                <th width="150px">Contract end date</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript" class="init">
        $('#table_id').DataTable({
            "language": {
                'searchPlaceholder': "Search by goods",
                "lengthMenu": "Show _MENU_ Contracts"
            },
            "processing": true,
            "serverSide": true,
            "ajax": '/api/data',
            "ajaxDataProp": '',
            "columns": [
                {'data': 'contractNumber'},
                {'data': 'id', 'className': 'hide'},
                {'data': 'goods.mdValue', "defaultContent": "-"},
                {'data': 'contractDate', 'className': 'dt'},
                {'data': 'finalDate', 'className': 'dt'},
                {'data': 'amount', "className":'numeric-data' }
            ],
            "fnDrawCallback": function () {
                changeDateFormat();
                numericFormat();
                createLinks();
            }
        });

        var createLinks = function () {

            $('#table_id tbody tr').each(function () {
                $(this).css('cursor', 'pointer');
                $(this).click(function () {
                    var contractId = $(this).find("td:nth-child(2)").text();
                    return window.location.assign(window.location.origin + "/contracts/" + contractId);
                });

            });
        };
    </script>
@endsection
