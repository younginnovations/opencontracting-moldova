<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moldova Open Contracting Portal Newsletter</title>
</head>
<body>

<div style=" width: 620px;
            margin: 0 auto;
            font-family: 'Helvetica';
            border: 8px solid #f5f5f5;
            padding: 8px;">
    <table >
        <tbody>
        <tr>
            <td>
                <img align="center" alt=""
                src="https://gallery.mailchimp.com/5be4e3c4761402dd284943876/images/347c8cf8-1a34-416b-bc84-67f27f46556a.png"
                style="max-width: 100%;"
                >
            </td>
        </tr>
        </tbody>
    </table>
    <table style="padding: 32px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.16);">
        <thead>
            <tr style="text-align: left;">
                <th style="width: 310px; font-size: 14px; font-weight: 400; color: #5A5A5A; ">Total Contract Value</th>
                <th style="width: 310px; font-size: 14px; font-weight: 400; color: #5A5A5A;">No. of Contracts</th>
            </tr>
        </thead>

        <tbody>
        <tr>
            <td style="font-weight: 600; font-size:24px; color: #5A5A5A;">{{number_format($totalContractAmount)}} MDL</td>
            <td style="font-weight: 600; font-size:24px; color: #5A5A5A;">{{number_format($totalContractCount)}}</td>
        </tr>
        </tbody>
    </table>
    <table>
        <tbody>
        <tr>
            <td style="padding: 24px 0 0 0; font-size: 24px; color: #5a5a5a;">{{ date('Y') }} <span style="font-size: 14px;">(Last Updated: {{ $import_date }})</span></td>
        </tr>
        </tbody>
    </table>
    <table style="padding: 24px 0 0 0;">
        <thead>
        <tr style="text-align: left;">
            <th style="width: 310px; font-size: 14px; font-weight: 400; color: #5A5A5A; ">Total Contract Value</th>
            <th style="width: 310px; font-size: 14px; font-weight: 400; color: #5A5A5A;">No. of Contracts</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td style="font-weight: 600; font-size:24px; color: #5A5A5A;">{{number_format($yearTotalContracts)}} MDL</td>
            <td style="font-weight: 600; font-size:24px; color: #5A5A5A;">{{number_format($getYearContractorsCount)}}</td>
        </tr>
        </tbody>
    </table>

    <table style="padding: 32px 0 32px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.16);">
        <thead>
        <tr style="text-align: left;">
            <th style="width: 206px; font-size: 14px; font-weight: 400; color: #5A5A5A; ">Procuring Agencies</th>
            <th style="width: 206px; font-size: 14px; font-weight: 400; color: #5A5A5A;">Contractors</th>
            <th style="width: 206px; font-size: 14px; font-weight: 400; color: #5A5A5A;">Goods And Services</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td style="font-weight: 600; font-size:24px; color: #5A5A5A;">{{number_format($totalAgency)}}</td>
            <td style="font-weight: 600; font-size:24px; color: #5A5A5A;">{{number_format($totalContractorsCount)}}</td>
            <td style="font-weight: 600; font-size:24px; color: #5A5A5A;">{{number_format($totalGoods) }}</td>
        </tr>
        </tbody>
    </table>


    <table style="padding: 32px 0 14px 0;">
        <tbody>
        <tr style="font-size: 18px; font-weight: 600; color: #5A5A5A"><td>Recently Signed</td></tr>
        </tbody>
    </table>


    <table style="text-align: left;  border-bottom: 1px solid rgba(0, 0, 0, 0.16); padding-bottom: 32px;">
        <thead>
        <tr>
            <th style="width: 310px; font-size: 14px; font-weight: 600; color: #5A5A5A; padding: 12px 0;">Contract</th>
            <th style="width: 206px; font-size: 14px; font-weight: 600; color: #5A5A5A; padding: 12px 0;">Period</th>
        </tr>
        </thead>

        <tbody>
        @foreach($recentlySigned as $item)
            <tr>
                <td style="font-size: 14px; color: #5A5A5A; padding: 12px 0;"><a href="{{ route('contracts.view', [$item->id]) }}">{{ $item->contractNumber . " " . $item->tender['tenderData']['goodsDescr'] }} </a></td>
                <td style="font-size: 14px; color: #5A5A5A; padding: 12px 0;">{{ $item->contractDate->toDateTime()->format('Y-m-d') }} ({{ mongoToDate($item->contractDate)  }})</td>
            </tr>
        @endforeach

        </tbody>

    </table>

    <table style="padding: 32px 0 14px 0;">
        <tbody>
        <tr style="font-size: 18px; font-weight: 600; color: #5A5A5A"><td>Ending soon</td></tr>
        </tbody>
    </table>


    <table style="text-align: left;">
        <thead>
        <tr>
            <th style="width: 310px; font-size: 14px; font-weight: 600; color: #5A5A5A; padding: 12px 0;">Contract</th>
            <th style="width: 206px; font-size: 14px; font-weight: 600; color: #5A5A5A; padding: 12px 0;">Period</th>
        </tr>
        </thead>

        <tbody>
        @foreach($endingSoon as $item)
        <tr>
            <td style="font-size: 14px; color: #5A5A5A; padding: 12px 0;"><a href="{{ route('contracts.view', [$item->id]) }}">{{ $item->contractNumber . " " . $item->tender['tenderData']['goodsDescr'] }} </a></td>
            <td style="font-size: 14px; color: #5A5A5A; padding: 12px 0;"> {{ $item->finalDate->toDateTime()->format('Y-m-d') }} ({{ mongoToDate($item->finalDate) }})</td>
        </tr>
            @endforeach
        </tbody>

    </table>

</div>
{{--footer--}}
<table border="0" cellpadding="0" cellspacing="0" width="100%"
       style="background:#fafafa none no-repeat center/cover;background-color:#fafafa;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:9px;padding-bottom:9px;min-width:100%;border-collapse:collapse">
    <tbody>
    <tr>
        <td valign="top" style="padding-top:9px">
            <table align="left" border="0" cellpadding="0" cellspacing="0"
                   style="max-width:100%;min-width:100%;border-collapse:collapse"
                   width="100%">
                <tbody>
                <tr>
                    <td valign="top"
                        style="padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;word-break:break-word;color:#656565;font-family:Helvetica;font-size:12px;line-height:150%;text-align:center">
                        <em>Copyright © 2017 PUBLIC PROCUREMENT AGENCY, All rights
                            reserved.</em><br>
                        You are receiving this email because you have subscribed to our
                        newsletter.<br>
                        <br>
                        <strong>Our mailing address is:</strong><br>
                        <a href=" http://tender.gov.md/en " target="_blank">PUBLIC
                            PROCUREMENT AGENCY</a><br>
                        MD-2028, MUN., HIGHWAY HINCESTI 53<br>
                        CHISINAU, MOLDOVA<br>
                        +373-22 23-42-80 <br>
                        <br>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</body>
</html>