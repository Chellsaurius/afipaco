<div class="modal fade" id="verPago{{ $local->local_id }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="updateMerchant{{ $merchant->merchant_curp }}Label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verPago{{ $local->local_id }}">Detalles del ultimo pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row" >
                    <div class="d-flex justify-content-between row">
                        <div class="mb-3 col-12 border">
                            <label for="folio" class="form-label">Folio</label>
                            <input type="text" name="folio" id="folio{{ $local->local_id }}" class="form-control text-uppercase" 
                                id="folio" aria-describedby="folioeHelp" readonly>
                        </div>
                        <div class="mb-3 col-12 border">
                            <label for="finalDate" class="form-label">Fecha final del contrato</label>
                            <input type="text" name="finalDate{{ $local->local_id }}" id="finalDate{{ $local->local_id }}" class="form-control text-uppercase" 
                                id="finalDate" aria-describedby="finalDateHelp" readonly>
                        </div>
                        
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>