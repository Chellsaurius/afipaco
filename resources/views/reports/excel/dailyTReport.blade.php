<?php 
header('Content-type: application/vnd.ms-excel'); 
header("Content-Disposition: attachment; filename=reporte_por_tipo.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
?> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Reporte por tipo</title> 
</head> 
<body> 
    <TABLE BORDER=1 align="center" CELLPADDING=1 CELLSPACING=1> 
        <TR> 
            <th>Folio</th>
            <th>Nombre</th>
            <th>Fecha del pago</th>
            <th>Tianguis (día)</th>
            <th>Giro(s)</th>
            <th>Vigencia</th>
            <th>Medidas</th>
            <th>Cantidad </th>
            <th>Lugar</th> 
        </TR> 
        <tbody>
            
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->payment_folio }}</td>
                    <td>{{ $payment->payment_name }}</td>
                    <td>{{ ($payment->created_at) }} </td>
                    <td>{{ $payment->payment_localVenue }} ({{$payment->payment_daysText }})</td>
                    <td>{{ trim($payment->payment_activities, ',') }}</td>
                    <td>Del: {{ date('d-m-Y', strtotime($payment->payment_startingDate ?? '')) }} al {{ date('d-m-Y', strtotime($payment->payment_endingDate ?? '')) }}</td>
                    <td>{{ $payment->payment_dimentions }}</td>
                    <td>$ {{ number_format($payment->payment_amount, 2) }}</td>
                    <td>{{ $payment->payment_place }}</td>
                </tr>
                
            @endforeach
            
        </tbody>
    </TABLE> 
</body> 
</html>