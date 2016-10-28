<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">

		html, body {
			height: 100%;
		}

		html {
			display: table;
			margin: auto;
		}

		body {
			display: table-cell;
			vertical-align: middle;
		}
		.container{
			overflow: auto;
			/*box-shadow: 10px 10px 5px #888888;*/
		}
		.header{
			text-align: center;
			clear: both;
		}
		.header-total{
			clear: both;
		}
		.info{
			border-top: 1px solid #8c8b8b;
			clear: both;
		}
		body{
			align-content: center;
			max-width: 564px;
			min-width: 260px;
			background-color: #edeeef;
		}
		.amount{
			width: 50%;
			float: left;
		}
		.count{
			width: 50%;
			float: right;
		}
		footer{
			border-top: 1px solid #8c8b8b;
			text-align: center;
			background-color: #d0d4db;
			clear: both;
		}
		h4{
			color: rgba(5, 43, 82, 0.97);
		}
		h6{
			color: #193063;
		}
	</style>
    <title>*|MC:SUBJECT|*</title>
</head>
<body>
<div class="container">
    <div class="header">
        <h1 class="title">Moldova Weekly Newsletter</h1><br>
        <img align="center" alt="" src="https://gallery.mailchimp.com/5be4e3c4761402dd284943876/images/db6ec904-f584-4af6-8f5f-9bdb779127f5.jpg" width="564">
        <div class="header-total">
            <div class="amount">
                <h4>Total Contract Value</h4>
				<h6>{{number_format($totalContractAmount)}}</h6>
            </div>
            <div class="count">
                <h4>Total Contract Count</h4>
				<h6>{{number_format($totalContractCount)}}</h6>
            </div>
        </div>
    </div>

    <div class="info">
        <div class="amount">
            <h4>{{number_format($totalAgency)}} Procuring Agencies</h4>
            <h6>TOP 5(By Amount)</h6>
            <ul>
				@foreach($procuringAgencyByAmount as $item)
					<li>{{$item->name .'-'. number_format($item->value)}}</li>
				@endforeach
            </ul>
        </div>
        <div class="count">
            <br>
            <br>
            <h6>TOP 5(By Count)</h6>
            <ul>
				@foreach($procuringAgencyByCount as $item)
					<li>{{$item->name.'-'. number_format($item->value)}}</li>
				@endforeach
            </ul>
        </div>
    </div>
    <div class="info">
        <div class="amount">
            <h4>{{number_format($totalContractorsCount)}} Contractors</h4>
            <h6>TOP 5(By Amount)</h6>
            <ul>
				@foreach($contractorsByAmount as $item)
					<li>{{$item->name[0].'-'. number_format($item->value)}}</li>
				@endforeach
            </ul>
        </div>
        <div class="count">
            <br>
            <br>
            <h6>TOP 5(By Count)</h6>
            <ul>
				@foreach($contractorsByCount as $item)
					<li>{{$item->name[0].'-'.number_format($item->value)}}</li>
				@endforeach
            </ul>
        </div>
    </div>
    <div class="info">
        <div class="amount">
            <h4>{{$totalGoods}} Goods</h4>
            <h6>TOP 5(By Amount)</h6>
            <ul>
				@foreach($goodsAndServicesByAmount as $item)
					<li>{{$item->name[0].'-'.number_format($item->value)}}</li>
				@endforeach
            </ul>
        </div>
        <div class="count">
            <br>
            <br>
            <h6>TOP 5(By Count)</h6>
            <ul>
				@foreach($goodsAndServicesByCount as $item)
					<li>{{(isset($item->name[0])?$item->name[0]:'').'-'.number_format($item->value)}}</li>
				@endforeach
            </ul>
        </div>
    </div>
</div>
<footer>
	<em>Copyright © *|CURRENT_YEAR|* *|LIST:COMPANY|*, All rights reserved.</em><br>
	*|IFNOT:ARCHIVE_PAGE|* *|LIST:DESCRIPTION|*<br>
	<br>
	<strong>Our mailing address is:</strong><br>
	*|HTML:LIST_ADDRESS_HTML|* *|END:IF|*<br>
	<br>
	Want to change how you receive these emails?<br>
	You can <a href="*|UPDATE_PROFILE|*">update your preferences</a> or <a href="*|UNSUB|*">unsubscribe from this list</a><br>
	*|IF:REWARDS|* *|HTML:REWARDS|* *|END:IF|*
</footer>
</body>
</html>