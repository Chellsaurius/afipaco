<script>
    function newValue(id) {
        // console.log('EL ID DEL local ES: ' + id)
        var area = document.getElementById("area" + id).value;
        var fiscalAmount = document.getElementById("fiscalAmount" + id).value;
        document.getElementById("IDatePayment" + id).disabled = false;

        let total = area * fiscalAmount;
        // console.log(area);
        // console.log(fiscalAmount);
        // console.log(total);
        var PPD = document.getElementById("PPD" + id);
        PPD.value = total.toFixed(2);
        // console.log('el valor a cobrar es: ' + total)

        var fecha = document.getElementById("FDatePayment" + id).value; 
        if (fecha != '') {
            // console.log('entró');
            daysDifference(id)
        }
        // console.log(fecha);
    }
</script>
<script>
    function activateDateEnd(activation) {
        // console.log(activation)
        if (this.value == '0') {
            document.getElementById("FDatePayment" + activation).disabled = true;
        } else {
            document.getElementById("FDatePayment" + activation).disabled = false;
        }

        var fecha = document.getElementById("FDatePayment" + activation).value;
        if (fecha != '') {
            // console.log('entró 2');
            daysDifference(activation)
        }
    }
</script>
<script>
    function daysDifference(id) {
        // console.log('EL ID DEL LOCAL ES: ' + id)
        // console.log("IDatePayment" + id)
        
        var dateI1 = document.getElementById("IDatePayment" + id).value;
        var dateI2 = document.getElementById("FDatePayment" + id).value;
        var costo = document.getElementById("PPD" + id).value;
        // console.log(dateI1 + ', ' + dateI2 + 'costo ' + costo)
        //console.log('leyó las variables')
        //define two date object variables to store the date values  
        var date1 = new Date(dateI1);
        var date2 = new Date(dateI2);
        date1.setDate(date1.getDate() + 1)
        date2.setDate(date2.getDate() + 1)

        // console.log(date1 + ', ' + date2)
        var ano1 = date1.getFullYear();
        var ano2 = date2.getFullYear();
        // console.log(ano1 + ', ' + ano2)
        if (date1 > date2) {
            alert('La fecha final es menor a la fecha de inicio')
        }

        //if (ano1 == ano2) {
        result = 'positive';
        //calculate time difference  
        //var time_difference = date2.getTime() - date1.getTime();  
        //console.log('la variable time es: ' + time_difference)
        //calculate days difference by dividing total milliseconds in a day  
        //var result = time_difference / (1000 * 60 * 60 * 24);  
        //console.log('el resultado de dividir es: ' + result)
        var dias = document.getElementById("daysN" + id).value;
        // console.log('el día es: ' + dias)
        var cadena = dias.split(",");
        //cadena = parseInt(cadena) + 1;
        //cadena = cadena.toString();
        // console.log('la cadena es: ' + cadena)

        const start = date1;
        const end = date2;
        //console.log('las fechas del loop son: ' + start + ' a, ' + end)
        const weekday = ["7", "1", "2", "3", "4", "5", "6"];
        var dt = new Date(); /* today */
        //console.log('la variable DT original es: ' + dt)
        dt.setFullYear(ano1); /* actual year */
        dt.setMonth(9, 31); /* 31st of Oct as should be by spec */
        //console.log('la variable DT nueva es: ' + dt)
        var counter = 0;

        dt.setHours(0, 0, 0, 0);
        // console.log(dt)
        let loop = new Date(start);
        loop.setHours(0, 0, 0, 0);
        do {
            //console.log("EL LOOP EN DATE AL INICIO ES: " + loop)
            if (weekday[loop.getDay()] == cadena && loop != dt) {
                counter = counter + 1;
                //console.log("entró al día número: " + weekday[loop.getDay()])
                //console.log("contador: " + counter)
            } else if (weekday[loop.getDay()] == cadena && loop == dt) {
                counter = counter + 1;
                //console.log('ENTRÓ AL SEGUNDO IF ------------------')

            } else {
                counter = counter;
            }
            let newDate = loop.setDate(loop.getDate() + 1);
            loop = new Date(newDate);
            loop.setHours(0, 0, 0, 0);
            //console.log("EL LOOP EN DATE ES: " + loop)

            //console.log('el loop al terminar es: ' + weekday[loop.getDay()]);
        } while (loop <= end);
        loop.setHours(0, 0, 0, 0);
        dt.setHours(0, 0, 0, 0)
        //console.log('FUERA DEL DOWHILE LOOP ES: ' + loop)
        //console.log('FUERA DEL DOWHILE DT ES: ' + dt)
        /*if (start.toDateString() <= dt.toDateString() || end.toDateString() >= dt.toDateString()) {
            console.log("/////////// ENTRÓ A LA COMPARACIÓN ***************: con el valor" + loop.toDateString() + dt.toDateString())
            
            console.log('el loopgetday de fuera es: ' + weekday[loop.getDay()])
            console.log('la cadena a comparar es: ' + cadena)
            if (weekday[loop.getDay()] == cadena) {
                counter = counter + 1;
                console.log("//////////entró al día número: " + weekday[loop.getDay()])
                console.log("//////////contador: " + counter)
            }
            let newDate = loop.setDate(loop.getDate() + 1 );
            loop = new Date(newDate);
        }*/
        let total = counter * PPD;
        var result = document.getElementById("dWorked" + id);
        result.value = counter;
        var subtotal = document.getElementById("subtotal" + id);
        subtotal.value = total.toFixed(2);
        // here I check if the result does have decimals, to extract and show
        var roundedTotal = total.toFixed(0);
        console.log(roundedTotal);
        var rounded = roundedTotal - total;
        console.log(rounded);
        var result = document.getElementById("total" + id);
        var tarifAdjustment = document.getElementById('tarifAdjustment' + id);
        tarifAdjustment.value = rounded.toFixed(2);
        result.value = roundedTotal;
        /*
        } else {
            result = 'NOT positive';
            alert ("Los años son distintos.");  
        } */
        //return document.getElementById("result").innerHTML = total;  
    }
</script>
<script>
    function show_my_receiptTia(id) {
        //console.log(id)
        
        var id = id;
        checkbox = document.getElementById("check" + id);
        if (checkbox.checked) {
            //console.log('entró')
            document.getElementById("btn" + id).disabled = 'true';
            var url = '/ajaxGuardarPago';
            var id = document.getElementById('local_id' + id).value;
            var merchant_id = document.getElementById('merchant_id' + id).value;
            var category = document.getElementById('category' + id).value;
            var localVenue = document.getElementById('localVenue' + id).value;
            var name = document.getElementById('name' + id).value;
            var activities = document.getElementById('business' + id).value;
            var ubication = document.getElementById('ubication' + id).value;
            var daysT = document.getElementById('daysT' + id).value;
            var fiscalAmount = document.getElementById('fiscalAmount' + id).value;
            var IDatePayment = document.getElementById('IDatePayment' + id).value;
            var FDatePayment = document.getElementById('FDatePayment' + id).value;
            var area = document.getElementById('area' + id).value;
            var measurements = document.getElementById('measurements' + id).value;
            // var ppd = document.getElementById('PPD' + id).value;
            var dWorked = document.getElementById('dWorked' + id).value;
            var total = document.getElementById('total' + id).value;
            var tarifAdjustment = document.getElementById('tarifAdjustment' + id).value;
            // console.log(url);
            // console.log(id);
            // console.log(merchant_id);
            // console.log(name);
            // console.log(activities);
            // console.log(ubication);
            // console.log(daysT);
            // console.log(fiscalAmount);
            // console.log(IDatePayment);
            // console.log(FDatePayment);
            // console.log(area);
            // console.log(measurements);
            // console.log(dWorked);
            // console.log(total);
            // console.log('esos son todos los datos');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    local_id: id,
                    merchant_id: merchant_id,
                    name: name,
                    activities: activities,
                    ubication: ubication,
                    daysT: daysT,
                    fiscalAmount: fiscalAmount,
                    IDatePayment: IDatePayment,
                    FDatePayment: FDatePayment,
                    area: area,
                    measurements: measurements,
                    // ppd: ppd,
                    dWorked: dWorked,
                    category: category,
                    localVenue: localVenue,
                    total: total,
                    tarifAdjustment: tarifAdjustment,
                }
            }).done(function(payments) {
                console.log(payments)

                // open the page as popup //

                var page = '/imprimirPago/' + payments.payment_id;
                //var page = 'https://afipaco.salamanca.gob.mx/imprimirPago/' + payments.payment_id; 

                var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=1000,top=0");

                // focus on the popup //
                myWindow.focus();

                // if you want to close it after some time (like for example open the popup print the receipt and close it) //

                //  setTimeout(function() {
                //    myWindow.close();
                //  }, 1000);

                location.href = '/ListaPagosPendientes';
                // location.href = 'https://afipaco.salamanca.gob.mx/ListaPagosPendientes';
            })
        } else {
            alert('Verifique que los datos sean correctos y maque la respectiva casilla.')
        }

    }
</script>
