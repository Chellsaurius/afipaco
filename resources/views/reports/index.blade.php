@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Reportes</title>
@endsection

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Panel de reportes</div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            
                            <a class="btn btn-primary" data-bs-toggle="modal" href="#paymentsQuickReport" role="button">Reporte rápido de ingresos</a>
                            @include('reports.modals.paymentsQuickReport')

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#paymentsReportShow">
                                <i class="fa-solid fa-address-book"></i> Generar reporte de pagos
                            </button>
                            @include('reports.modals.paymentsReportShow')
                        </div>
                        <hr>
                        
                        @if (isset($tyears))
                            <h2>Reporte diario</h2>
                            <form class="row" action="{{ route('report.daily') }}" method="POST">
                                @csrf
                                <div class="d-flex justify-content-start row">
                                    <input type="hidden" name="cat" value="tianguis">
                                    <h3>Tianguis</h3>
                                    <div class="mb-3 col-4 border pb-2">
                                        <label for="year" class="form-label">Año</label>
                                        <select name="year" id="tyear" class="form-control" value="{{ old('year') }}" onchange="tNewYear()" 
                                            aria-placeholder="tyear" required>
                                            <option value="" disabled selected>Selecciona año</option>
                                            @foreach ($tyears as $year)
                                                <option value="{{ $year->year }}">{{ $year->year }}</option>
                                            @endforeach
                                        </select>
                                        @error('year')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-4 border" id="tmes" style="display:none">
                                        <label for="month" class="form-label">Mes</label>
                                        <select name="month" id="tmonth" class="form-control" value="{{ old('month') }}"
                                            onchange="tNewMonth()" aria-placeholder="month" >
                                            <option value="" disabled selected>Selecciona mes</option>
                                        </select>
                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-4 border pb-2" id="tdia" style="display:none">
                                        <label for="day" class="form-label">Día</label>
                                        <select name="day" id="tday" class="form-control" value="{{ old('day') }}"
                                            aria-placeholder="day" required>
                                            <option value="" disabled selected>Selecciona día</option>
                                        </select>
                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="col-12 ml-4 d-flex justify-content-between">
                                        <button type="submit" name="buscarD" value="1" class="btn btn-primary col-3">Buscar diario</button>
                                        <button type="submit" name="descargarD" value="2" class="btn btn-primary col-3"><i
                                            class="fa-solid fa-file-arrow-down"></i> Descargar reporte diario de tianguis</button>
                                    </div>
                                    
                                </div>
                            </form>
                            <br>
                        @else
                            {{ 'noentró' }}
                        @endif
                    

                        @if (isset($vpyears))
                            <form class="row" action="{{ route('report.daily') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cat" value="viapublica">
                                <div class="d-flex justify-content-start row">
                                    <h3>Vía Pública</h3>
                                    <div class="mb-3 col-4 border pb-2">
                                        <label for="year" class="form-label">Año</label>
                                        <select name="year" id="vpyear" class="form-control" value="{{ old('year') }}"
                                            onchange="vpNewYear()" aria-placeholder="vpyear" required>
                                            <option value="" disabled selected>Selecciona año</option>
                                            @foreach ($vpyears as $year)
                                                <option value="{{ $year->year }}">{{ $year->year }}</option>
                                            @endforeach

                                        </select>
                                        @error('year')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror

                                    </div>
                                    <div class="mb-3 col-4 border" id="vpmes" style="display:none">
                                        <label for="month" class="form-label">Mes</label>
                                        <select name="month" id="vpmonth" class="form-control" value="{{ old('month') }}"
                                            onchange="vpNewMonth()" aria-placeholder="month" required>
                                            <option value="" disabled selected>Selecciona mes</option>
                                        </select>
                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-4 border pb-2" id="vpdia"  style="display:none">
                                        <label for="day" class="form-label">Día</label>
                                        <select name="day" id="vpday" class="form-control" value="{{ old('day') }}"
                                            aria-placeholder="day" required>
                                            <option value="" disabled selected>Selecciona día</option>
                                        </select>
                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-12 ml-4 d-flex justify-content-between">
                                        <button type="submit" name="buscarD" value="1" class="btn btn-primary col-3">Buscar
                                            diario</button>
                                        <button type="submit" name="descargarD" value="2" class="btn btn-primary col-3"><i
                                                class="fa-solid fa-file-arrow-down"></i> Descargar reporte diario de vía
                                            pública</button>
                                    </div>
                                </div>
                            </form>
                            <br><br>
                        @else
                            {{ 'No hay datos...' }}
                        @endif

                        @if (isset($ocationalDailyYear))
                            <form class="row" action="{{ route('report.daily') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cat" value="ocational">
                                <div class="d-flex justify-content-start row">
                                    
                                    <h3>Ocasionales</h3>
                                    <div class="mb-3 col-4 border pb-2">
                                        <label for="year" class="form-label">Año</label>
                                        <select name="year" id="ocationalYear" class="form-control" value="{{ old('year') }}"
                                            onchange="ocationalNewYear()" aria-placeholder="ocationalYear" required>
                                            <option value="" disabled selected>Selecciona año</option>
                                            @foreach ($ocationalDailyYear as $year)
                                                <option value="{{ $year->year }}">{{ $year->year }}</option>
                                            @endforeach

                                        </select>
                                        @error('year')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror

                                    </div>
                                    <div class="mb-3 col-4 border" id="ocationalMonth" style="display:none">
                                        <label for="month" class="form-label">Mes</label>
                                        <select name="month" id="ocationalMonthSelect" class="form-control" value="{{ old('month') }}"
                                            onchange="OcationalSelectMonth()" aria-placeholder="month" required>
                                            <option value="" disabled selected>Selecciona mes</option>
                                        </select>
                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-4 border pb-2" id="ocationalDailyDayDiv"  style="display:none">
                                        <label for="day" class="form-label">Día</label>
                                        <select name="day" id="ocationalDailyDay" class="form-control" value="{{ old('day') }}"
                                            aria-placeholder="day" required>
                                            <option value="" disabled selected>Selecciona día</option>
                                        </select>
                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-12 ml-4 d-flex justify-content-between">
                                        <button type="submit" name="buscarD" value="1" class="btn btn-primary col-3">Buscar
                                            diario</button>
                                        <button type="submit" name="descargarD" value="2" class="btn btn-primary col-3"><i
                                                class="fa-solid fa-file-arrow-down"></i> Descargar reporte diario de ocasionales</button>
                                    </div>
                                </div>
                            </form>
                            <br><br>
                        @else
                            {{ 'No hay datos...' }}
                        @endif

                        <hr>

                        <h3>Reporte acumulado</h3>
                        <form class="row" action="{{ route('report.acumulated') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cat" value="tianguis">
                            <div class="d-flex justify-content-start row pb-3">

                                <h3>Tianguis</h3>
                                <div class="mb-3 col-5 border col align-self-center" id="FI">
                                    <label for="IDatePayment" class="form-label"> Selecciona la fecha de inicio. </label>
                                    <span id="aviso"></span>
                                    <input type="date" id="IDatePayment" name="IDatePayment" class="form-control"
                                        min="{{ date_format(date_create($tars->created_at), 'Y-m-d') ?? 'no hay' }}" aria-describedby="iDateHelp"
                                        max="{{ date_format(date_create($tarf->created_at), 'Y-m-d') }}" required>
                                    <div id="iDateHelp" class="form-text">Fecha en la que inicia el permiso. </div>
                                </div>
                                <div class="mb-3 col-5 border col align-self-center" id="FF">
                                    <label for="FDatePayment" class="form-label"> Selecciona la fecha de finalización. </label>
                                    <input type="date" id="FDatePayment" name="FDatePayment" class="form-control"
                                        min="{{ date_format(date_create($tars->created_at), 'Y-m-d') }}" aria-describedby="fDateHelp"
                                        max="{{ date_format(date_create($tarf->created_at), 'Y-m-d') }}" required>
                                    <div id="fDateHelp" class="form-text">Fecha en la que termina el permiso.</div>
                                </div>

                                <div class="col-12 ml-4 d-flex justify-content-between">
                                    <button type="submit" name="buscarD" value="1" class="btn btn-primary col-3">Buscar acumulado</button>
                                    <button type="submit" name="descargarD" value="2" class="btn btn-primary col-3"> <i
                                        class="fa-solid fa-file-arrow-down"></i> Descargar reporte acumulado</button>
                                </div>
                            </div>
                        </form>
                        
                        <br><br>

                        <form class="row" action="{{ route('report.acumulated') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cat" value="viapublica">
                            <div class="d-flex justify-content-start row pb-3">
                                <h3>Vía pública</h3>
                                <div class="mb-3 col-5 border col align-self-center" id="FI">
                                    <label for="IDatePayment" class="form-label"> Selecciona la fecha de inicio. </label>
                                    <span id="aviso"></span>
                                    <input type="date" id="IDatePayment" name="IDatePayment" class="form-control"
                                        min="{{ date_format(date_create($vpars->created_at), 'Y-m-d') }}" aria-describedby="iDateHelp"
                                        max="{{ date_format(date_create($vparf->created_at), 'Y-m-d') }}" required>
                                    <div id="iDateHelp" class="form-text">Fecha en la que inicia el permiso. </div>
                                </div>
                                <div class="mb-3 col-5 border col align-self-center" id="FF">
                                    <label for="FDatePayment" class="form-label"> Selecciona la fecha de finalización. </label>
                                    <input type="date" id="FDatePayment" name="FDatePayment" class="form-control"
                                        min="{{ date_format(date_create($vpars->created_at), 'Y-m-d') }}" aria-describedby="fDateHelp"
                                        max="{{ date_format(date_create($vparf->created_at), 'Y-m-d') }}" required>
                                    <div id="fDateHelp" class="form-text">Fecha en la que termina el permiso.</div>
                                </div>
                                <div class="col-12 ml-4 d-flex justify-content-between">
                                    <button type="submit" name="buscarD" value="1" class="btn btn-primary col-3">Buscar
                                        acumulado</button>
                                    <button type="submit" name="descargarD" value="2" class="btn btn-primary col-3"> <i
                                        class="fa-solid fa-file-arrow-down"></i> Descargar reporte acumulado</button>
                                </div>
                            </div>
                        </form>
                        
                        <br><br>

                        <form class="row" action="{{ route('report.acumulated') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cat" value="ocationals">
                            <div class="d-flex justify-content-start row pb-3">
                                <h3>Ocasionales</h3>
                                <div class="mb-3 col-5 border col align-self-center" id="FI">
                                    <label for="IDatePayment" class="form-label"> Selecciona la fecha de inicio. </label>
                                    <span id="aviso"></span>
                                    <input type="date" id="IDatePayment" name="IDatePayment" class="form-control"
                                        min="{{ date_format(date_create($ocationalsAcumulatedStart->created_at), 'Y-m-d') }}" aria-describedby="iDateHelp"
                                        max="{{ date_format(date_create($ocationalsAcumulatedEnd->created_at), 'Y-m-d') }}" required>
                                    <div id="iDateHelp" class="form-text">Fecha en la que inicia el permiso. </div>
                                </div>
                                <div class="mb-3 col-5 border col align-self-center" id="FF">
                                    <label for="FDatePayment" class="form-label"> Selecciona la fecha de finalización. </label>
                                    <input type="date" id="FDatePayment" name="FDatePayment" class="form-control"
                                        min="{{ date_format(date_create($ocationalsAcumulatedStart->created_at), 'Y-m-d') }}" aria-describedby="fDateHelp"
                                        max="{{ date_format(date_create($ocationalsAcumulatedEnd->created_at), 'Y-m-d') }}" required>
                                    <div id="fDateHelp" class="form-text">Fecha en la que termina el permiso.</div>
                                </div>
                                <div class="col-12 ml-4 d-flex justify-content-between">
                                    <button type="submit" name="buscarD" value="1" class="btn btn-primary col-3">Buscar
                                        acumulado</button>
                                    <button type="submit" name="descargarD" value="2" class="btn btn-primary col-3"> <i
                                        class="fa-solid fa-file-arrow-down"></i> Descargar reporte acumulado</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    @include('reports.js.index')

@endsection
