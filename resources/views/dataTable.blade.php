@extends('app')

@section('content')
    <div class="row table-wrapper">
        <table id="table_id" class="hover custom-table display">
        <thead>
            <tr>
                <th>Contract Number</th>
                <th>Goods</th>
                <th>Contract Date</th>
                <th>Final Date</th>
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
            "processing": true,
            "serverSide": true,
            "ajax": '/api/data',
            "ajaxDataProp": '',
            "columns": [
                { 'data': 'contractNumber'},
                { 'data': 'goods.mdValue'},
                { 'data': 'contractDate'},
                { 'data': 'finalDate'},
                { 'data': 'amount'}
            ]
        });
    </script>
@endsection
