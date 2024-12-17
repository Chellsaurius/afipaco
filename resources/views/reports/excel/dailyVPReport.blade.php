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
            <th>Nombre</th>
            <th>Ubicación del negocio</th>
            <th>Colonia del comerciante</th>
            <th>Giro(s)</th>
            <th>Medidas</th>
            <th>Días que labora</th>
            <th>Vigencia</th>
            <th>Folio</th>
            <th>Fecha del pago</th>
            <th>Monto</th>
        </TR> 
        <tbody>
            
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->payment_name }}</td>                                
                    <td>{{ $payment->payment_place }}</td>
                    <td>{{ $payment->RPaymentsMerchant->merchant_address }}</td>
                    <td>{{ trim($payment->payment_activities, ',') }}</td>
                    <td>{{ $payment->payment_dimentions }}</td>
                    <td>{{ $payment->payment_daysText }}</td>
                    <td>Del: {{ date_format(date_create($payment->payment_startingDate), 'd-m-Y') }} al: {{ date_format(date_create($payment->payment_endingDate), 'd-m-Y') }}</td>
                    <td>{{ $payment->payment_folio }}</td>
                    <td>{{ date_format(date_create($payment->created_at), 'd-m-Y h:i A') }} </td>
                    <td>$ {{ number_format($payment->payment_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </TABLE> 
</body> 
</html>