@foreach(range(date('Y'), 2012) as $year)
    <option value="{{$year}}">{{$year}}</option>
@endforeach