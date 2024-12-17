<script>
    function nDays(id, event) {
        // console.log('id: ' + id);
        // console.log(event);

        var checkbox = event.target; // Get the checkbox element
        var isChecked = checkbox.checked; // Check if the checkbox is checked
        var dayValue = Number(checkbox.value); // Get the value of the checkbox
        var checkboxId = checkbox.id;
        // console.log(isChecked);
        console.log('dayValue: ' + dayValue);        
        // console.log('checkboxId: ' + checkboxId);

        var daysInput = document.getElementById('daysN' + id);
        var checkbox = document.getElementById(checkboxId);
        // console.log('daysInput: ' + daysInput);
        // console.log('checkbox: ' + checkbox);
        
        let daysArray = daysInput.value.split(',').filter(Boolean).map(Number);
        // console.log('se crea el split filter');
        console.log('daysArray: ' + daysArray);
        console.log(checkbox.checked);
        if (checkbox.checked) {
            daysArray.push(dayValue);
            console.log('entró al if');
        } else {
            console.log('no entró al if');
            console.log(daysArray.indexOf(dayValue));
            const index = daysArray.indexOf(Number(dayValue));
            console.log('index: ' + index);
            if (index !== -1) {
                daysArray.splice(index, 1);
                console.log('daysArray dentro del if: ' + daysArray);
            }
        }

        daysArray.sort((a, b) => a - b);
        daysInput.value = daysArray.join(',');
        // console.log('después del sort');
        console.log('daysArray: ' + daysArray);
        // console.log('daysInput: ' + daysInput);
        var fecha = document.getElementById("FDatePayment" + id).value;
        if (fecha != '') {
            // console.log('entró');
            daysDifferenceOca(id)
        }
    }
</script>
<script>
    function enableButton(id) {
        // console.log(id);
        var result = document.getElementById("PPD" + id);
        var fecha = document.getElementById("FDatePayment" + id).value;
        var checkbox = document.getElementById("check" + id);

        if (fecha != '' && result != '') {
            document.getElementById("btn" + id).disabled = false;

        } else {
            alert("Ingrese datos");

            checkbox.checked = false;
        }
        if (checkbox.checked == false) {
            document.getElementById("btn" + id).disabled = true;
        }

    }
</script>
<script>
    function newValueOca(id) {
        var places = document.getElementById("places" + id).value;
        var fiscalAmount = document.getElementById("fiscalAmount" + id).value;

        var measurements = document.getElementById("measurements" + id).value;
        //alert (monto * costo);
        // console.log(places);
        // console.log(fiscalAmount);
        // console.log(measurements);

        let total = places * fiscalAmount;
        var result = document.getElementById("PPD" + id);
        result.value = total.toFixed(2);
        // console.log('el valor a cobrar es: ' + total)
        // fi.style.display = "block";
        // document.getElementById("IDatePayment"+id).disabled = false;

        var extraMeter = document.getElementById("extraMeter" + id);
        if (extraMeter) {
            // console.log('entró por que si hay metros extra');
            extraMeter.removeAttribute('disabled');

        } else {
            var result = document.getElementById("PPD" + id).value;
            if (result != '') {
                // console.log('entró al else, cambio de valor total');
                var fi = document.getElementById("IDatePayment" + id);
                fi.removeAttribute('disabled');

            }
        }
        var fecha = document.getElementById("FDatePayment" + id).value;
        if (fecha != '') {
            // console.log('entró, cambio en los días');
            daysDifferenceOca(id)
        }


    }
</script>
<script>
    function startingDateOca(id) {
        var fi = document.getElementById("IDatePayment" + id);
        var extraMeter = document.getElementById("extraMeter" + id).value;
        var totalExtra = document.getElementById("totalExtra" + id).value;
        // console.log(extraMeter);
        // console.log(totalExtra);

        var ppd = document.getElementById("PPD" + id).value;
        // console.log(value);
        let total = Number(ppd) + (Number(extraMeter) * Number(totalExtra));


        // console.log(total);
        var result = document.getElementById("PPD" + id);
        result.value = total.toFixed(2);
        // console.log(result);

        fi.removeAttribute('disabled');

        var measurements = document.getElementById("measurements" + id).value;
        // console.log(measurements);
        var fecha = document.getElementById("FDatePayment" + id).value;
        if (fecha != '') {
            // console.log('entró');
            daysDifferenceOca(id)
        }
    }
</script>
<script>
    function activateDateEndOca(id) {
        // console.log(activation)
        if (this.value == '0') {
            document.getElementById("FDatePayment" + id).disabled = true;
        } else {
            document.getElementById("FDatePayment" + id).disabled = false;
        }

        var fecha = document.getElementById("FDatePayment" + id).value;
        if (fecha != '') {
            // console.log('entró 2');
            daysDifferenceOca(id)
        }
    }
</script>
<script>
    function daysDifferenceOca(id) {
        // console.log("IDatePayment")
        // console.log(id);
        //define two variables and fetch the input from HTML form  
        var dateI1 = document.getElementById("IDatePayment" + id).value;
        var dateI2 = document.getElementById("FDatePayment" + id).value;
        var costo = document.getElementById("PPD" + id).value;
        // console.log(dateI1)
        // console.log(dateI2)
        // console.log(costo)
        var checkboxIds = ["day7" + id, "day1" + id, "day2" + id, "day3" + id, "day4" + id, "day5" + id, "day6" + id];
        var checkboxValues = [];
        for (var i = 0; i < checkboxIds.length; i++) {
            var checkbox = document.getElementById(checkboxIds[i]);
            checkboxValues.push(checkbox.checked ? 1 : 0);
        }
        console.log(checkboxValues);
        var date1 = new Date(dateI1);
        var date2 = new Date(dateI2);
        date1.setDate(date1.getDate() + 1)
        date2.setDate(date2.getDate() + 1)

        // console.log(date1 + ', '+ date2)
        var ano1 = date1.getFullYear();
        var ano2 = date2.getFullYear();
        // console.log(ano1 + ', '+ ano2)
        if (date1 > date2) {
            alert('La fecha final es menor a la fecha de inicio')
        }

        var dias = checkboxValues;
        dias = dias.toString();
        // console.log('el día es: ' + dias)
        cadena = dias.split(",");
        //cadena = parseInt(cadena) + 1;
        //cadena = dias.toString();
        // console.log('la cadena es: ' + cadena)

        const start = date1;
        const end = date2;
        // console.log('las fechas del loop son: ' + start + ' a, ' + end)
        const weekday = ["7", "1", "2", "3", "4", "5", "6"];
        let loop = new Date(start);
        loop.setHours(0, 0, 0, 0);
        var counter = 0;
        do {
            // console.log("EL LOOP EN DATE AL INICIO ES: " + loop)
            // console.log('el día de la semana es: ' + weekday[loop.getDay()]);
            // console.log('el día de la cadena es: ' + cadena[loop.getDay()]);
            if (weekday[loop.getDay()] && cadena[loop.getDay()] == 1) {
                counter += 1;
                // console.log("entró al día número: " + weekday[loop.getDay()])
                // console.log("contador: " + counter)
            } else {
                counter = counter;
            }
            let newDate = loop.setDate(loop.getDate() + 1);
            loop = new Date(newDate);
            loop.setHours(0, 0, 0, 0);
            // console.log("EL LOOP EN DATE ES: " + loop)

            // console.log('el loop al terminar es: ' + weekday[loop.getDay()]);
        } while (loop <= end);

        // console.log('FUERA DEL DOWHILE LOOP ES: ' + loop)
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
    }
</script>
<script>
    function show_my_receiptOca(id) {
        // console.log(id)

        checkbox = document.getElementById("check" + id);
        var IDatePayment = document.getElementById('IDatePayment' + id).value;
        var FDatePayment = document.getElementById('FDatePayment' + id).value;
        var extraMeters = document.getElementById('extraMeters' + id).value;
        var total = document.getElementById('total' + id).value;

        if (checkbox.checked && IDatePayment != '' && FDatePayment != '' && extraMeters !== null && total != '') {
            //console.log('entró')
            document.getElementById("btn" + id).disabled = 'true';
            var url = '/ajaxGuardarPago';
            var id = document.getElementById('local_id' + id).value;
            var merchant_id = document.getElementById('merchant_id' + id).value;
            var localVenue = document.getElementById('localVenue' + id).value;
            var name = document.getElementById('name' + id).value;
            var category = document.getElementById('category' + id).value;
            var activities = document.getElementById('business' + id).value;
            var ubication = document.getElementById('ubication' + id).value;
            var daysN = document.getElementById('daysN' + id).value;
            var fiscalAmount = document.getElementById('fiscalAmount' + id).value;
            var area = document.getElementById('area' + id).value;
            var extraMeterAmountElement = document.getElementById("extraMeter" + id);
            var tarifAdjustment = document.getElementById('tarifAdjustment' + id).value;
            if (extraMeterAmountElement) {
                var extraMeterAmount = extraMeterAmountElement.value;
                // Now you can use extraMeterAmount
                console.log(extraMeterAmount);
            } else {
                // Handle the case where the element doesn't exist
                console.log("Element not found");
                var extraMeterAmount = 0;
            }
            var measurements = document.getElementById('measurements' + id).value;
            // var ppd = document.getElementById('PPD').value;
            var dWorked = document.getElementById('dWorked' + id).value;
            // console.log(url);
            // console.log(id);
            // console.log(merchant_id);
            // console.log(name);
            // console.log(activities);
            // console.log(ubication);
            // console.log(daysN);
            // console.log(fiscalAmount);
            // console.log(IDatePayment);
            // console.log(FDatePayment);
            // console.log(area);
            // console.log(extraMeters);
            // console.log(measurements);
            // console.log(dWorked);
            // console.log(total);
            // console.log('esos son todos los datos');
            
            if (daysN.charAt(daysN.length - 1) === ',') {
                daysN = daysN.slice(0, -1);
                // console.log(daysN);
                const dayNumbers = daysN.split(',').map(Number);
                const dayNames = ['', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
                // console.log(dayNumbers);
                // console.log(dayNames);
                const dayNamesArray = dayNumbers.map(dayNumber => {
                    if (dayNumber >= 0 && dayNumber < dayNames.length) {
                        return dayNames[dayNumber];
                    } else {
                        return 'Invalid Day';
                    }
                });
                // console.log(dayNamesArray);
                var daysT = dayNamesArray;
            } else {
                // console.log(daysN);
                const dayNumbers = daysN.split(',').map(Number);
                const dayNames = ['', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
                // console.log(dayNumbers);
                // console.log(dayNames);
                const dayNamesArray = dayNumbers.map(dayNumber => {
                    if (dayNumber >= 0 && dayNumber < dayNames.length) {
                        return dayNames[dayNumber];
                    } else {
                        return 'Invalid Day';
                    }
                });
                // console.log(dayNamesArray);
                var daysT = dayNamesArray;
            }
            daysT = daysT.join(', ');
            

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
                    daysN: daysN,
                    daysT: daysT,
                    fiscalAmount: fiscalAmount,
                    IDatePayment: IDatePayment,
                    FDatePayment: FDatePayment,
                    area: area,
                    extraMeters: extraMeters,
                    extraMeterAmount: extraMeterAmount,
                    measurements: measurements,
                    // ppd: ppd,
                    dWorked: dWorked,
                    category: category,
                    localVenue: localVenue,
                    total: total,
                    tarifAdjustment: tarifAdjustment,
                }
            }).done(function(payments) {
                //console.log(payments)

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

                    // si desea realizar otro pago solo recargo por seguridad para evitar que algunos datos queden llenos
                var result = confirm("¿Desea realizar otro pago?"); 
                if (result === true) {
                    location.reload();
                } else {
                    location.href = '/ListaPagosPendientes';
                    //location.href = 'https://afipaco.salamanca.gob.mx/ListaPagosPendientes';
                }
            })
        } else {
            alert('Verifique que los datos sean correctos y maque la respectiva casilla.')
        }

    }
</script>
