<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet"/>
    <style>
        .headt td {
            min-width: 200px;
            height: 30px;

        }
        table {

        }
    </style>
</head>
<body>
    <title>DIRECCIÓN DE FISCALIZACIÓN Y CONTROL</title>
    <div style="margin: 5px" class="d-flex justify-content-between">
        <a class="btn btn-primary"onclick="window.open('', '_self', ''); window.close();""> Regresar</a>
        <a class="btn btn-primary" onclick="vista('printArea')"> Imprimir comprobante</a>
    </div>
    <div class="container"  id="printArea" style="width: 18.5cm">
        <br><br><br>
        <legend class="text-center text-white" style="background-color: grey !important; padding-bottom: 10px; padding-right: 10px; margin-bottom: -10px;">DIRECCIÓN DE FISCALIZACIÓN Y CONTROL</legend>
        
        <form class="row g-1 " action="#" method="post" style="padding: 3px;">
            <div class="d-flex flex-row-reverse mb-1" >
                <div class="" style="height: 26px; width: 300px">
                    <p >FOLIO: {{ $pago->payment_folio }}</p>
                </div>
            </div>
            <div class="col-6 rounded text-center" style="height: 26px">
                <label for="nombre" class="form-label">ORDEN DE PAGO</label>
                
            </div>
            <div class="col-6  rounded text-center" style="height: 26px">
                <label for="apellidos" class="form-label">FECHA DE EXPEDICIÓN: {{ date('d-m-Y') }}</label>
                
            </div>
            
            <div class="col-12  rounded pb-" style="height: 38px">
                <p style="font-size: 10px; margin-bottom: 10px;" class="text-uppercase"> EL CIUDADANO: {{ $pago->comerciante->merchant_names }} 
                    <br>
                    EFECTUA EL PAGO EN LA TESORERÍA MUNICIPAL POR LA CANTIDAD DE: <b style="font-size: 14px"> &nbsp; $<u>{{ $pago->payment_amount }} MXN</u></b> 
                    &nbsp; &nbsp; POR EL CONCEPTO DE:
                </p>
                
            </div>
            <div class="col-12 rounded pb-1 d-flex justify-content-evenly row  ">
                <div style="height: 34px">
                    <p><b>DISPOSICIONES ADMINISTRATIVAS DE RECAUDACIÓN PARA EL MUNICIPIO DE SALAMANCA, GUANAJUATO, PARA EL EJERCICIO FISCAL {{ date('Y') }}</b></p>
                </div>
                <div class="col-6  d-flex justify-content-center row align-items-center p-1">
                    <div class=" d-flex justify-content-start" style="height: 32px">
                        <p style="font-size: 10px ">1.- ART. 6 LA OCUPACIÓN Y PROVECHAMIENTO DE LA VÍA PÚBLICA POR LOS PARTICULARES:</p>
                    </div>
                    <div class=" d-flex justify-content-between " style="height: 24px">
                        <p class="col col-11 mt-1" style="font-size: 10px "> FRACCIÓN I</p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start " style="height: 24px">
                        <p class="col col-11 align-middle mt-1" style="font-size: 10px "> FRACCIÓN II</p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 24px">
                        <p class="col col-11 align-middle mt-1" style="font-size: 10px "> FRACCIÓN III</p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" >
                        <p class="col col-11" style="font-size: 10px; height: 16px">2.- ART. 8 PERMISO POR EXTENSIÓN DE HORARIO A ESTABLECIMINENTOS COMERCIALES.</p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 64px">
                        <p class="col col-11" style="font-size: 10px ">3.- ART. 19 EMPADRONAMIENTO DE MESAS DE BILLAR, MÁQUINAS DE VIDEOJUEGOS, APARATOS ELECTROMECÁNICOS, JUEGOS MECÁNICOS O SIMILARES, CAMA ELÁSTICA.</p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 34px">
                        <p class="col col-11" style="font-size: 10px ">4.- ART. 20 EXPEDICIÓN DE PERMISO POR EMPADRONAMIENTO MINICIPAL.</p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    

                </div>
                <div class="col-6  d-flex justify-content-center row p-1">
                    <div class=" d-flex justify-content-start" style="height: 48px">
                        <p class="col col-11"  style="font-size: 10px ">5.- ART. 21 POR INSPECCIÓN FÍSICA OCULAR PARA ANUENCIA DE LICENCIA DE GIROS CON VENTA DE BEBIDAS ALCOHÓLICAS.</p>
                        <div class=" border border-dark -2 col col-1 mt-1 align-middle" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 24px">
                        <p class="col col-11"  style="font-size: 10px ">6.- ART. 22 PUBLICIDAD POR VOLANTEO POR DÍA.</p>
                        <div class=" border border-dark -2 col col-1 mt-1 align-middle" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 34px">
                        <p class="col col-11"  style="font-size: 10px ">7.- ART. 23 POR INSPECCIÓN FÍSICA OCULAR PARA PERMISO DE VÍA PÚBLICA. </p>
                        <div class=" border border-dark -2 col col-1 mt-1 align-middle" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 18px">
                        <p class="col col-11"  style="font-size: 10px ">8.- ART. 24 SELLADO DE BOLETOS: </p>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 24px">
                        <p class="col col-11 mt-1"  style="font-size: 10px "> I.- HASTA 1000 UNIDADES. </p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 24px">
                        <p class="col col-11 mt-1"  style="font-size: 10px "> A) 1001 A 5000 UNIDADES. </p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 24px">
                        <p class="col col-11 mt-1"  style="font-size: 10px "> B) 5001 UNIDADES EN ADELANTE. </p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 34px">
                        <p class="col col-11" style="font-size: 10px "> II.- AMPLIACIÓN DE HORARIO PARA SALONES DE FIESTA DESTINADOS A EVENTOS PRIVADOS O PÚBLICOS. </p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    
                </div>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div class="col-12 rounded pb-1 d-flex justify-content-evenly row" >
                <div style="height: 44px">
                    <p><b>LEY DE INGRESOS PARA EL MUNICIPIO DE SALAMANCA, GUANAJUATO, PARA EL EJERCICIO FISCAL DEL AÑO {{ date('Y') }}</b></p>
                </div>
                <div class="col-6  d-flex justify-content-center row align-items-center p-1">
                    <div class=" d-flex justify-content-start" style="height: 34px">
                        <p class="col col-11" style="font-size: 10px; height: 16px">1.- SECCIÓN 5TA ART. 10 IMPUESTO SOBRE JUEGOS Y APUESTAS PERMITIDAS.</p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 34px">
                        <p class="col col-11" style="font-size: 10px ">2.- SECCIÓN 6TA ART. 11 IMPUESTO DIVERSIONES Y ESPECTÁCULOS PÚBLICOS.</p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                </div>
                <div class="col-6  d-flex justify-content-center row p-1">
                    
                    <div class=" d-flex justify-content-start" style="height: 34px">
                        <p class="col col-11"  style="font-size: 10px ">3.- ART. 28 FRACCIÓN III EXPEDICIÓN DE PERMISOS POR DÍA PARA LA DIFUSIÓN FONÉTICA: </p>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 24px">
                        <p class="col col-11 mt-1"  style="font-size: 10px "> A) FIJA. </p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    <div class=" d-flex justify-content-start" style="height: 24px">
                        <p class="col col-11 mt-1"  style="font-size: 10px "> b) MÓVIL. </p>
                        <div class=" border border-dark -2 col col-1 mt-1" style="height: 15px; width: 28px"></div>
                    </div>
                    
                </div>
            </div>
            <div class="col-12  rounded pb-1" style="height: 24px">
                <p style="font-size: 14px; "> LUGAR: <b> {{ $pago->local->local_location }} </b>
                   
                </p>
                
            </div>
            <div class="col-md-12  rounded d-flex justify-content-start row px-1 mx-1" style="height: 66px">
                <p style="font-size: 14px; " class="d-flex align-items-center col-12"> 
                    <b> CALCULOS </b>   
                </p>
                <p class="d-flex align-items-center col-12" style="font-size: 14px;" >
                    DÍAS LABORADOS = {{ $pago->merchant_days_laborales }} * COSTO FISCAL =  ${{ $monto->amount_cost }} * DIMENSIONES = {{ $pago->local->local_dimx }} * {{ $pago->local->local_dimy }}m, TOTAL = ${{ $pago->payment_amount }}
                </p>
            </div>
            <div class="col-12  rounded pb-1" style="height: 86px">
                <p style="font-size: 14px; "> 
                    
                    COLONIA: <b> {{ $pago->comerciante->merchant_address }} </b>
                    <br>
                    GIRO(S): <b> {{ $pago->comerciante->merchant_activity }} </b>
                    <br>
                    DENOMINACIÓN: 
                    <br>
                    VIGENCIA DEL: <b> {{ $pago->fecha_inicio }} AL: {{ $pago->payment_endingDate }} </b>
                </p>
                
            </div>
            <div class="col-12 rounded pb-1 d-flex justify-content-center " style="height: 24px">
                <p style="font-size: 14px; "> ATENTAMENTE </p>
                <br>
                <br>
                <br>
                
            </div>
            <div class="col-12 rounded pb-1 d-flex justify-content-center ">
                <div style="height: 34px">
                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                </div>
                <div class="col-6 border d-flex justify-content-center row align-items-center ">
                    <div class=" col-12 border d-flex justify-content-center align-items-end" style="height: 82px">
                        
                        <hr size="6" width="400px" align="center  " color="red">
                    </div>
                    <div class=" col-12 border d-flex justify-content-center " >
                        
                        <p class="d-flex justify-content-center" style="font-size: 10px; height: 36px"> <br> 
                            C. LIC.JUAN GERSON ORTA DE LUNA
                            <br>
                            DIRECTOR DE FISALIZACIÓN Y CONTROL
                        </p>
                        
                    </div>
                   
                    
                </div>
                
            </div>
            
        </form>

    </div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    function vista(printArea) {
        var content = document.getElementById(printArea).innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = content;

        window.print();

        document.body.innerHTML = originalContent;
    }
</script>
</html>