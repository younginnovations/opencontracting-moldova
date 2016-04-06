@extends('app')

@section('content')
    <div class="row table-wrapper">
        <table id="table_id" class="responsive hover custom-table display">
            <thead>
            <tr>
                <th class="contract-number">Contract number</th>
                <th class="hide">Contract ID</th>
                <th>Goods and services contracted</th>
                <th width="150px">Contract start date</th>
                <th width="150px">Contract end date</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            @forelse($contracts as $contract)
                <tr>
                    <td>{{ $contract->contractNumber }}</td>
                    <td class="hide">{{ $contract->id }}</td>
                    <td>{{ $contract->goods['mdValue'] }}</td>
                    <td class="dt">{{ $contract->contractDate }}</td>
                    <td class="dt">{{ $contract->finalDate }}</td>
                    <td class="numeric-data">{{ $contract->amount }}</td>
                </tr>
            @empty
                <span>No results found.</span>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection