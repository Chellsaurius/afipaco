<div class="modal fade" id="paymentsReportShow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar reporte rápido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <!-- <form class="row col-mb-12" action="{{ route('report.generate') }}" method="POST"> -->
                <form class="row col-mb-12">
                    @csrf
                    
                    <div class="d-flex justify-content-between row">
                        <div class="mb-3 col-12 border form-control "> 
                            <div class="row " >
                                <div class="@error('dia') is-invalid @enderror"></div>
                                <label for="tipo" class="form-label">Seleccione tipo de comercio</label>
                                <div class="d-flex justify-content-left col-4 border align-items-center p-2">
                                    <input type="checkbox" name="tianguis" value="Tianguis" class="form-check-input m-1" id="tianguis">
                                    <label class="form-check-label" for="tianguis"> Tianguis</label>
                                </div>
                                <div class="d-flex justify-content-left col-4 border align-items-center p-2">
                                    <input type="checkbox" name="semifijo" value="Semifijo" class="form-check-input m-1" id="semifijo">
                                    <label class="form-check-label" for="semifijo"> Semifijo</label>
                                </div>
                                <div class="d-flex justify-content-left col-4 border align-items-center p-2">
                                    <input type="checkbox" name="ambulante" value="Ambulante" class="form-check-input m-1" id="ambulante">
                                    <label class="form-check-label" for="ambulante"> Ambulante</label>
                                </div>
                                <div class="d-flex justify-content-left col-4 border align-items-center p-2">
                                    <input type="checkbox" name="ocacional" value="Ocacional" class="form-check-input m-1" id="ocacional">
                                    <label class="form-check-label" for="ocacional"> Ocacional</label>
                                </div>

                                <div class="mb-3 col-4 border col align-self-center">
                                    <label for="initialDate" class="form-label"> Selecciona la fecha de inicio. </label>
                                    <br>
                                    <input type="date" id="QuickReportInitialDate" name="initialDate" class="form-control" aria-describedby="initialDateHelp" required>
                                    <div id="initialDateHelp" class="form-text">Fecha inicial para el reporte. </div>
                                </div>
                                
                                <div class="mb-3 col-4 border col align-self-center">
                                    <label for="finalDate" class="form-label"> Selecciona la fecha de finalización. </label>
                                    <input type="date" id="QuickReportFinalDate" name="finalDate" class="form-control" aria-describedby="finalDateHelp" required>
                                    <div id="finalDateHelp" class="form-text">Fecha final del reporte.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 ml-4">
                        <button type="submit" class="btn btn-primary col-6" onclick="generalReport()" target="_blank">Generar reporte</button>
                    </div>
                    
                </form>

            </div>
        </div>
    </div>
</div>

