@extends('app')

@section('content')
    <div class="buffer-top">
        <div class="block-with-margin filter-wrap">
            <div class="row">
                <div class="filter-inner clearfix">
                    <form class="search-wrap" action="{{ route('search') }}" method="get">
                        <div class="search-wrap">
                            <input type="search" name="q" class="" placeholder="Search">
                        </div>
                    </form>
                     <span class="filter-toggler">
                        <a class="show-filter">advance-filter</a>
                    </span>
                </div>
                <form action="{{ route('search') }}" method="get" class="custom-form advance-search-wrap">
                    <div class="form-inner clearfix">
                        <div class="form-group medium-4 columns end">
                            <select name="contractor" class="cs-select cs-skin-elastic">
                                <option value="" disabled selected>Select a contractor</option>
                                @forelse($contractTitles as $contractTitle)
                                    <option value="{{ $contractTitle['_id'][0] }}">{{ $contractTitle['_id'][0] }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group medium-4 columns end">
                            <select name="agency" class="cs-select cs-skin-elastic">
                                <option value="" disabled selected>Select a buyer</option>
                                @forelse($procuringAgencies as $procuringAgency)
                                    <option value="{{ $procuringAgency[0] }}">{{ $procuringAgency[0] }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group medium-4 columns end">
                            <select name="amount" class="cs-select cs-skin-elastic">
                                <option value="" disabled selected>Select a range</option>
                                <option value="0-10000">0-10000</option>
                                <option value="10000-100000">10000-100000</option>
                                <option value="100000-200000">100000-200000</option>
                                <option value="200000-500000">200000-500000</option>
                                <option value="500000-1000000">500000-1000000</option>
                                <option value="1000000-Above">1000000-Above</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group-button medium-12 clearfix">
                        <div class="medium-4 columns">
                            <input type="submit" class="button yellow-button" value="Submit">
                        </div>
                        <div class="medium-4 columns end">
                            <div class="button cancel-btn">Cancel</div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="block-with-margin">
        <div class="row">
            <div class="search-result-wrap block">
                <div class="title">Showing search result for:</div>
                <div class="search-token">
                    {!! (!empty($params['q']))?'<span><span class="cancel">x</span>'.$params['q'].'</span>':'' !!}
                    {!! (!empty($params['contractor'])) ?'<span><span class="cancel">x</span>Contractor :  '.$params['contractor'].' </span>': ''!!}
                    {!! (!empty($params['agency'])) ? '<span><span class="cancel">x</span>Procuring Agency : '.$params['agency'].' </span>': '' !!}
                    {!! (!empty($params['amount'])) ?'<span><span class="cancel">x</span>Amount :  '.$params['amount'].' </span>' : '' !!}
                </div>
                <div class="button-group clearfix">
                    <div class="button btn cancel-btn">Cancel</div>
                    <div class="button btn reset-btn">Reset</div>
                </div>
            </div>
        </div>
    </div>
    @if(sizeof($contracts)==0)
        <div class="block-with-margin">
            <div class="row">
                <div class="search-result-wrap block">
                    <div class="negative-result">No result found</div>
                </div>
            </div>
        </div>
    @else

        <div class="row table-wrapper persist-area">
            <table id="table_id" class="responsive hover custom-table display">
                <thead class="persist-header">
                <tr>
                    <th class="contract-number">Contract number</th>
                    <th class="hide">Contract ID</th>
                    <th>Goods and services contracted</th>
                    <th>Contract status</th>
                    <th width="150px">Contract start date</th>
                    <th width="150px">Contract end date</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @forelse($contracts as $tender)

                    @foreach($tender['contract'] as $key => $contract)
                        <tr>
                            <td>{{ getContractInfo($contract['title'],'id') }}</td>
                            <td class="hide">{{ $contract['id'] }}</td>
                            <td>{{ ($tender['award'][$key]['items'])?$tender['award'][$key]['items'][0]['classification']['description']:'-' }}</td>
                            <td>{{ $contract['status'] }}</td>
                            <td class="dt">{{ $contract['dateSigned'] }}</td>
                            <td class="dt">{{ $contract['period']['endDate'] }}</td>
                            <td class="numeric-data">{{ $contract['value']['amount'] }}</td>
                        </tr>
                    @endforeach
                @empty
                    <span>No results found.</span>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif

@endsection

@section('script')
    <script src="{{url('js/responsive-tables.min.js')}}"></script>
    <script>
        var createLinks = function () {
            $('#table_id tbody tr').each(function () {
                $(this).css('cursor', 'pointer');
                $(this).click(function () {
                    var contractId = $(this).find("td:nth-child(2)").text();
                    return window.location.assign(window.location.origin + "/contracts/" + contractId);
                });

            });
        };

        var makeTable = $("#table_id").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_ Contracts"
            },
            "bFilter": false,
            "fnDrawCallback": function () {
                changeDateFormat();
                createLinks();
                updateTables();
                if ($('#table_id tr').length < 10 && $('a.current').text() === "1") {
                    $('.dataTables_paginate').hide();
                } else {
                    $('.dataTables_paginate').show();
                }
            }
        });

        createLinks();
    </script>
    <script src="{{url('js/fixedHeader.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            if ($(window).width() > 768) {
                new $.fn.dataTable.FixedHeader(makeTable);
            }

            $(window).resize(function () {
                new $.fn.dataTable.FixedHeader(makeTable);
            });

            $('.cancel').each(function(){
                $(this).click(
                function(e) {
                    e.preventDefault(); // prevent the default action
                    e.stopPropagation(); // stop the click from bubbling
                    $(this).parent().addClass('hide');
                });

            });

        });
    </script>
@endsection
