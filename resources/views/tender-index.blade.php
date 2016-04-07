@extends('app')

@section('content')
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
            @forelse($tenders as $tender)
                <tr href="/tenders/{{$tender['tender']['id'] }}">
                    <td>{{ $tender['tender']['id'] }}</td>
                    <td>{{ $tender['tender']['title'] }}</td>
                    <td>{{ $tender['tender']['status'] }}</td>
                    <td>{{ $tender['tender']['procuringAgency']['name'] }}</td>
                    <td class="dt">{{ $tender['tender']['tenderPeriod']['startDate'] }}</td>
                    <td class="dt">{{ $tender['tender']['tenderPeriod']['endDate'] }}</td>
                </tr>

            @empty
                No Results found
            @endforelse

            </tbody>
        </table>
        {!! $tenders->render() !!}
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#table_id tbody tr').click(function () {
                window.location = $(this).attr('href');
                return false;
            });
        });
    </script>
    <style>
        table tr {
            cursor: pointer;
        }
    </style>
@endsection