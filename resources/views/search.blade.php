@extends('app')

@section('content')
    <div class="buffer-top">
        <div class="row">
            <div class="filter-wrap">
            <div class="filter-inner clearfix">
                <div class="search-wrap">
                    <input type="search" class="" placeholder="Search">
                </div>

             <span class="filter-toggler">
                <a class="show-filter">advance-filter</a>
                 {{--<a class='hide-filter'>Hide filter</a>--}}
            </span>
            </div>


                <form action="" class="custom-form advance-search-wrap">
                    <div class="form-inner clearfix">
                        <div class="form-group medium-4 columns end">
                            {{--<label class="control-label">Partners </label>--}}
                            <select class="cs-select cs-skin-elastic">
                                <option value="" disabled selected>Select a Country</option>
                                <option value="france" >France</option>
                                <option value="brazil" >Brazil</option>
                                <option value="argentina" >Argentina</option>
                                <option value="south-africa">South Africa</option>
                            </select>
                        </div>
                        <div class="form-group medium-4 columns end">
                            {{--<label class="control-label">Partners </label>--}}
                            <select class="cs-select cs-skin-elastic">
                                <option value="" disabled selected>Select a Country</option>
                                <option value="france" >France</option>
                                <option value="brazil" >Brazil</option>
                                <option value="argentina" >Argentina</option>
                                <option value="south-africa">South Africa</option>
                            </select>
                        </div>
                        <div class="form-group medium-4 columns end">
                            {{--<label class="control-label">Partners </LABEL>--}}
                            <select class="cs-select cs-skin-elastic">
                                <option value="" disabled selected>Select a Country</option>
                                <option value="france" >France</option>
                                <option value="brazil" >Brazil</option>
                                <option value="argentina" >Argentina</option>
                                <option value="south-africa">South Africa</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group-button medium-12 clearfix">
                        <div class="medium-4 columns">
                            <input type="submit" class="button blue-button" value="Submit">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="search-result-wrap block">
            <div class="title">Showing search result for:</div>
            <div class="search-token">
                <span>search token 1</span>
                <span>search token 2</span>
                <span>search token 3</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="search-result-wrap block">
            <div class="negative-result">No result found</div>
        </div>
    </div>


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