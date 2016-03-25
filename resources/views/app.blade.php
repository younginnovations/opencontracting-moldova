<html>
<head>
    <title>Moldova OCDS</title>
</head>
<body>
<div>
    <h2>Tenders Trends</h2>
    @forelse($tenders as $key => $tender)
        <p>{{$key . ' : ' . $tender}}</p>
    @empty
    @endforelse

    <h2>Contracts Trends</h2>
    @forelse($contracts as $key => $contract)
        <p>{{$key . ' : ' . $contract}}</p>
    @empty
    @endforelse
</div>
</body>
</html>