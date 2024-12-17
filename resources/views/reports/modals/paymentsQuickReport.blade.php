<div class="modal fade" id="paymentsQuickReport" aria-hidden="true" aria-labelledby="paymentsQuickReportLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="paymentsQuickReportLabel">Generar reporte rápido</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between row">
                    <div class="mb-3 col-12 border form-control ">
                        <div class="row ">
                            <div class="mb-3 col-6 border col align-self-center">
                                <label for="initialDate" class="form-label"> Selecciona la fecha de <br> inicio.
                                </label>
                                <br>
                                <input type="date" id="quickReportInitialDate" name="initialDate"
                                    class="form-control" aria-describedby="initialDateHelp" value="" required>
                                <div id="initialDateHelp" class="form-text">Fecha inicial para el reporte. </div>
                            </div>
                            <div class="mb-3 col-6 border col align-self-center">
                                <label for="finalDate" class="form-label"> Selecciona la fecha de finalización. </label>
                                <input type="date" id="quickReportFinalDate" name="finalDate" class="form-control"
                                    aria-describedby="finalDateHelp" value="" required>
                                <div id="finalDateHelp" class="form-text">Fecha final del reporte.</div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal"
                    onclick="quickReport()">Generar reporte</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentReportShowToggleLabel2">El resultado del reporte es: </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="col-12 pt-1">
                <input type="text" id="mostrarA" class="form-control col-4" readonly>
            </div>
            <div class="col-12 pt-1">
                <input type="text" id="mostrarS" class="form-control col-4" readonly>
            </div>
            <div class="col-12 pt-1">
                <input type="text" id="mostrarT" class="form-control col-4" readonly>
            </div>
            <div class="col-12 pt-1">
                <input type="text" id="mostrarO" class="form-control col-4" readonly>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>