<script>
    function nDays(params) {
        // console.log(params);
        var daysInput = document.getElementById('daysN');
        var checkbox = document.getElementById(`day${params}`);
        
        // Get the current days string from the input
        let daysArray = daysInput.value.split(',').filter(Boolean).map(Number); // Split and convert to an array of numbers

        // Check if the checkbox is checked
        if (checkbox.checked) {
            // Add the day number to the array
            daysArray.push(params);
            // console.log(daysArray);
        } else {
            // Remove the day number from the array
            const index = daysArray.indexOf(params);
            if (index !== -1) {
                daysArray.splice(index, 1);
            }
        }
        // Sort the array in ascending order
        daysArray.sort((a, b) => a - b);

        // Update the input value with the sorted days array
        daysInput.value = daysArray.join(',');
        console.log(daysArray);
        
        var fecha = document.getElementById("FDatePayment").value;
        if (fecha != '') {
            // console.log('entró');
            daysDifference()
        }
    }
</script>
<script>
    function newValue() {
        var places = document.getElementById("places").value;
        var fiscalAmount = document.getElementById("fiscalAmount").value;

        var measurements = document.getElementById("measurements").value;
        //alert (monto * costo);
        // console.log(places);
        // console.log(amount);
        // console.log(measurements);

        let total = places * fiscalAmount;
        var result = document.getElementById("PPD");
        result.value = total.toFixed(2);
        //console.log('el valor a cobrar es: ' + total)
        // fi.style.display = "block";
        // document.getElementById("IDatePayment"+id).disabled = false;

        var extraMeter = document.getElementById("extraMeter");
        if (extraMeter) {
            // console.log('entró por que si hay metros extra');
            extraMeter.removeAttribute('disabled');

        } else {
            var result = document.getElementById("PPD").value;
            if (result != '') {
                // console.log('entró al else, cambio de valor total');
                var fi = document.getElementById("IDatePayment");
                fi.removeAttribute('disabled');

            }
        }



    }
</script>
<script>
    function startingDate() {
        var fi = document.getElementById("IDatePayment");
        var extraMeter = document.getElementById("extraMeter").value;
        var totalExtra = document.getElementById("totalExtra").value;
        // console.log(extraMeter);
        // console.log(totalExtra);

        var value = document.getElementById("PPD").value;
        // console.log(value);
        let total = Number(value) + (Number(extraMeter) * Number(totalExtra));


        // console.log(total);
        var result = document.getElementById("PPD");
        result.value = total.toFixed(2);
        // console.log(result);

        fi.removeAttribute('disabled');

        var measurements = document.getElementById("measurements").value;
        // console.log(measurements);
        var fecha = document.getElementById("FDatePayment").value;
        if (fecha != '') {
            console.log('entró');
            daysDifference()
        }
    }
</script>
<script>
    function activateDateEnd() {
        // console.log(activation)
        if (this.value == '0') {
            document.getElementById("FDatePayment").disabled = true;
        } else {
            document.getElementById("FDatePayment").disabled = false;
        }

        var fecha = document.getElementById("FDatePayment").value;
        if (fecha != '') {
            console.log('entró 2');
            daysDifference()
        }
    }
</script>
<script>
    function daysDifference() {
        //define two variables and fetch the input from HTML form  
        var dateI1 = document.getElementById("IDatePayment").value;
        var dateI2 = document.getElementById("FDatePayment").value;
        var costo = document.getElementById("PPD").value;
        var checkboxIds = ["day7", "day1", "day2", "day3", "day4", "day5", "day6"];
        var checkboxValues = [];
        for (var i = 0; i < checkboxIds.length; i++) {
            var checkbox = document.getElementById(checkboxIds[i]);
            checkboxValues.push(checkbox.checked ? 1 : 0);
        }
        // console.log(checkboxValues);
        // var day1 = document.getElementById("day1");
        // if (day1.checked) {
        //     day1 = 1;
        // } else {
        //     day1 = 0;
        // }
        // var day2 = document.getElementById("day2");
        // if (day2.checked) {
        //     day2 = 1;
        // } else {
        //     day2 = 0;
        // }
        // var day3 = document.getElementById("day3");
        // if (day3.checked) {
        //     day3 = 1;
        // } else {
        //     day3 = 0;
        // }
        // var day3 = document.getElementById("day3");
        // if (day3.checked) {
        //     day3 = 1;
        // } else {
        //     day3 = 0;
        // }
        // var day4 = document.getElementById("day4");
        // if (day4.checked) {
        //     day4 = 1;
        // } else {
        //     day4 = 0;
        // }
        // var day5 = document.getElementById("day5");
        // if (day5.checked) {
        //     day5 = 1;
        // } else {
        //     day5 = 0;
        // }
        // var day6 = document.getElementById("day6");
        // if (day6.checked) {
        //     day6 = 1;
        // } else {
        //     day6 = 0;
        // }
        // var day7 = document.getElementById("day7");
        // if (day7.checked) {
        //     day7 = 1;
        // } else {
        //     day7 = 0;
        // }
        // console.log(dateI1 + ', ' + dateI2 + 'costo ' + costo)
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
        let total = counter * costo;
        // console.log('counter: ' + counter)
        // console.log('costo: ' + costo)
        // console.log('total: ' + total)
        var result = document.getElementById("dWorked");
        result.value = counter;
        // console.log('result: ' + result);
        var subtotal = document.getElementById("subtotal");
        subtotal.value = total.toFixed(2);
        // here I check if the result does have decimals, to extract and show
        var roundedTotal = total.toFixed(0);
        console.log(roundedTotal);
        var rounded = roundedTotal - total;
        console.log(rounded);
        var result = document.getElementById("total");
        var tarifAdjustment = document.getElementById('tarifAdjustment');
        tarifAdjustment.value = rounded.toFixed(2);
        result.value = roundedTotal;
    }
</script>
<script>
    function show_my_receiptOca(id) {
        // console.log(id)
        var id = id;
        checkbox = document.getElementById("check");
        if (checkbox.checked) {
            //console.log('entró')
            // document.getElementById("btn").disabled = 'true';
            var url = '/ajaxGuardarPago';
            var id = document.getElementById('local_id').value;
            var merchant_id = document.getElementById('merchant_id').value;
            var category = document.getElementById('category').value;
            var localVenue = document.getElementById('localVenue').value;
            var name = document.getElementById('name').value;
            var activities = document.getElementById('business').value;
            var ubication = document.getElementById('ubication').value;
            var daysN = document.getElementById('daysN').value;
            var fiscalAmount = document.getElementById('fiscalAmount').value;
            var IDatePayment = document.getElementById('IDatePayment').value;
            var FDatePayment = document.getElementById('FDatePayment').value;
            var area = document.getElementById('area').value;
            var extraMeters = document.getElementById('extraMeters').value;
            var extraMeterAmountElement = document.getElementById("extraMeter");
            if (extraMeterAmountElement) {
                var extraMeterAmount = extraMeterAmountElement.value;
                // Now you can use extraMeterAmount
                console.log(extraMeterAmount);
            } else {
                // Handle the case where the element doesn't exist
                console.log("Element not found");
                var extraMeterAmount = 0;
            }
            var measurements = document.getElementById('measurements').value;
            // var ppd = document.getElementById('PPD').value;
            var dWorked = document.getElementById('dWorked').value;
            var total = document.getElementById('total').value;
            // console.log(url);
            // console.log(id);
            // console.log(merchant_id);
            // console.log('category: ' + category);
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
