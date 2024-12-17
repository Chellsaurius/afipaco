<script>
    function quickReport() {
        var from = document.getElementById('quickReportInitialDate').value;
        var to = document.getElementById('quickReportFinalDate').value;
        if (from === '') {
            alert('Ingrese la fecha inicial');
        } else {
            if (to === '') {
                alert('Ingrese la fecha de finalización');
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/ajaxReporteRápido',
                    method: 'POST',
                    dataType: 'json',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        from: from,
                        to: to
                    }
                }).done(function(respuesta){
                    // console.log(respuesta)
                    var clase = [];
                    var total = [];
                    for (let index = 0; index < respuesta.length; index++) {
                        clase[index] = respuesta[index].payment_category
                        total[index] = parseFloat(respuesta[index].total).toLocaleString('es-MX', {
                            style: 'currency',
                            currency: 'MXN'
                        });
                    }
                    // console.log(clase, total)
                    
                    if (clase[0] != null && total[0] != null) {
                        $("#mostrarA").val(clase[0] + ": " + total[0]);// ID de la 1era caja de texto
                    }
                    else
                    {
                        $("#mostrarA").val("No hay.");
                    }
                    if (clase[1] != null && total[1] != null) {
                        $("#mostrarS").val(clase[1] + ": " + total[1]);// ID de la 2da caja de texto
                    }
                    else
                    {
                        $("#mostrarS").val("No hay.");
                    }
                    
                    if (clase[2] != null && total[2] != null) {
                        $("#mostrarT").val(clase[2] + ": " + total[2]);// ID de la 3ra caja de texto
                    }
                    else
                    {
                        $("#mostrarT").val("No hay.");
                    }
                    if (clase[4] != null && total[4] != null) {
                        $("#mostrarO").val(clase[4] + ": " + total[4]);// ID de la 1era caja de texto
                    }
                    else
                    {
                        $("#mostrarO").val("No hay.");
                    }
                })
            }
        }
    };
</script>
<script>
    function generalReport() {
        const tianguisCB = document.getElementById('tianguis');
        if (tianguisCB.checked) {
            // Get the value of the checkbox
            const t = checkbox.value;
            console.log('Checkbox is checked with value:', t);
        } else {
            console.log('Checkbox is not checked');
        }
        var t = document.getElementById('tianguis').value;
        var s = document.getElementById('semifijo').value;
        var a = document.getElementById('ambulante').value;
        var o = document.getElementById('ocacional').value;
        var from = document.getElementById('QuickReportInitialDate').value;
        var to = document.getElementById('QuickReportFinalDate').value;
        console.log(t);
        console.log(s);
        console.log(a);
        console.log(o);
        console.log(from);
        console.log(to);
        
        if ($from == '') {
            alert('Ingrese la fecha de inicio');
            if ($to == '') {
                alert('Ingrese la fecha final');
            }
            else {
                // open the page as popup //
                var page = 'http://localhost:8000/ajaxReporteRápido/' + t + '/' + s + '/' + a + '/' + o + '/' + from + '/' + to; 
                //var page = 'https://afipaco.salamanca.gob.mx/ajaxReporteRápido/' + t + '/' + s + '/' + a + '/' + o + '/' + from + '/' + to; 
                
                var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=1000,top=50");
            
                // focus on the popup //
                myWindow.focus();
                
                // if you want to close it after some time (like for example open the popup print the receipt and close it) //
                
                //  setTimeout(function() {
                //    myWindow.close();
                //  }, 1000);
            }
        }
    }
</script>

<script>
    function tNewYear() {
        //console.log('entró')
        //alert (monto * costo);
        //console.log(year)
        tmes.style.display = "block";
        tdia.style.display = "none";
        var year = document.getElementById("tyear").value;
        //console.log(year)
        var url = '/ajaxTMesReporteDiario';
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
                year: year,
            },
            success: function(data) {
                tmes.style.display = "block";
                // console.log(data)
                var control1 = data[0].month;
                var control2 = 0;
                var tmonths = "<option disabled selected>Selecciona mes</option>";
                for (let index = 0; index < data.length; index++) {
                    //console.log(data[index])
                    //var control1 = data[index];

                    control2 = data[index].month;
                    //console.log(control1, control2)
                    if (control1 == control2) {
                        control1 = control1 + 1;
                        tmonths += "<option >" + data[index].month + "</option>";
                        //control1 = data[index];
                        //console.log(control1, control2)
                    }
                }
                
                document.getElementById("tmonth").innerHTML = tmonths;
                tdia.style.display = "none";
            },
            error: function() {
                error = true;
                console.log("error en los datos: tNewYear")
                console.log(data)
            }
        })
    }
</script>
<script>
    function tNewMonth() {
        tdia.style.display = "none";
        var year = document.getElementById("tyear").value;
        var month = document.getElementById("tmonth").value;
        // console.log(year)
        // console.log(month)
        var url = '/ajaxTDiaReporteDiario';

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
                year: year,
                month: month,
            },
            success: function(data) {
                // console.log(data)
                var control1 = data[0].day;
                var control2 = 0;
                var tday = "<option disabled selected>Selecciona dia</option>";
                for (let index = 0; index < data.length; index++) {
                    //console.log(data[index])
                    //var control1 = data[index];
                    tday += "<option >" + data[index].day + "</option>";
                }
                document.getElementById("tday").innerHTML = tday;
                tdia.style.display = "block";
            },
            error: function() {
                error = true;
                console.log("error en los datos: tNewMonth")
                console.log(data)
            }
        })
    }
</script>
<script>
    function vpNewYear() {
        //console.log('entró')
        //alert (monto * costo);
        //console.log(year)
        vpmes.style.display = "block";
        vpdia.style.display = "none";
        var year = document.getElementById("vpyear").value;
        //console.log(year)
        var url = '/ajaxVPMesReporteDiario';

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
                year: year,
            },
            success: function(data) {
                // console.log(data)
                var control1 = data[0].month;
                var control2 = 0;
                var vpmonths = "<option disabled selected>Selecciona mes</option>";
                for (let index = 0; index < data.length; index++) {
                    //console.log(data[index])
                    //var control1 = data[index];

                    control2 = data[index].month;
                    //console.log(control1, control2)
                    if (control1 == control2) {
                        control1 = control1 + 1;
                        vpmonths += "<option >" + data[index].month + "</option>";
                        //control1 = data[index];
                        //console.log(control1, control2)
                    }


                }

                document.getElementById("vpmonth").innerHTML = vpmonths;

            },
            error: function() {
                error = true;
                console.log("error en los datos: vpNewYear")
                console.log(data)
            }
        })
    }
</script>
<script>
    function vpNewMonth() {
        vpdia.style.display = "none";
        var year = document.getElementById("vpyear").value;
        var month = document.getElementById("vpmonth").value;
        //console.log(year)
        //console.log(month)
        var url = '/ajaxVPDiaReporteDiario';
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
                year: year,
                month: month,
            },
            success: function(data) {
                // console.log(data)
                var control1 = data[0].day;
                var control2 = 0;
                var vpday = "<option disabled selected>Selecciona dia</option>";
                for (let index = 0; index < data.length; index++) {
                    //console.log(data[index])
                    //var control1 = data[index];
                    vpday += "<option >" + data[index].day + "</option>";
                }
                document.getElementById("vpday").innerHTML = vpday;
                vpdia.style.display = "block";

            },
            error: function() {
                error = true;
                console.log("error en los datos: vpNewMonth")
                console.log(data)
            }
        })
    }
</script>


{{-- aquí va todo lo nuevo del reporte de ocacionales --}}
<script>
    function ocationalNewYear() {
        // console.log('entró al reporte de ocacional')
        ocationalMonth.style.display = "block";
        tdia.style.display = "none";
        var year = document.getElementById("ocationalYear").value;
        // console.log(year)
        var url = '/ajaxOcationalMonthDailyReport';
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
                year: year,
            },
            success: function(data) {
                ocationalMonth.style.display = "block";
                console.log('la respuesta es: ' + data)
                var control1 = data[0].month;
                var control2 = 0;
                var OcationalMonths = "<option value=0 disabled selected>Selecciona mes</option>";
                for (let index = 0; index < data.length; index++) {
                    control2 = data[index].month;
                    if (control1 == control2) {
                        control1 = control1 + 1;
                        OcationalMonths += "<option >" + data[index].month + "</option>";
                    }
                }
                
                document.getElementById("ocationalMonthSelect").innerHTML = OcationalMonths;
                ocationalDailyDayDiv.style.display = "none";
            },
            error: function() {
                error = true;
                console.log("error en los datos: tNewYear")
                console.log(data)
            }
        })
    }
</script>
<script>
    function OcationalSelectMonth() {
        ocationalDailyDayDiv.style.display = "none";
        var year = document.getElementById("ocationalYear").value;
        var month = document.getElementById("ocationalMonthSelect").value;
        console.log(year)
        console.log(month)
        var url = '/ajaxOcationalDayDailyReport';

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
                year: year,
                month: month,
            },
            success: function(data) {
                console.log(data)
                var control1 = data[0].day;
                var control2 = 0;
                var ocationalDailyDay = "<option value=0 disabled selected>Selecciona dia</option>";
                for (let index = 0; index < data.length; index++) {
                    ocationalDailyDay += "<option >" + data[index].day + "</option>";
                }
                document.getElementById("ocationalDailyDay").innerHTML = ocationalDailyDay;
                ocationalDailyDayDiv.style.display = "block";
            },
            error: function() {
                error = true;
                console.log("error en los datos: ocational select month")
                console.log(data)
            }
        })
    }
</script>
