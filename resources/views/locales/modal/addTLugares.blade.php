<div class="modal fade" id="addTPlace" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Añadir un nuevo lugar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
            <form action="{{ route("local.addPlace") }}" method="post">
                @csrf
                <input type="hidden" name="local_id" value="{{ $local->local_id }}">
                <div class="col-12 border">
                    <label for="dimx" class="form-label">Ubicación </label>
                    <input type=text name="location" value="{{ $local->local_location }}" autocomplete="off" autofocus="on"class="form-control text-uppercase" id="location" aria-describedby="xHelp" required>
                    <div id="xHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                </div>
                <div class="col-12 border">
                    <label for="dimx" class="form-label">Dimensión X del lugar </label>
                    <input type=number step=0.01 name="dimx" autocomplete="off" autofocus="on" min=0.01 class="form-control" id="dimx" aria-describedby="xHelp" placeholder="X.XX" required>
                    <div id="xHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                </div>
                <div class="col-12 border">
                    <label for="dimy" class="form-label">Dimensión Y del lugar </label>
                    <input type=number step=0.01 name="dimy" autocomplete="off" autofocus="off" min=0.01 class="form-control" id="dimy" aria-describedby="yHelp" placeholder="Y.YY" required>
                    <div id="yHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                </div> 
                <div class="col-12 ml-4">
                    <div class="mb-3 form-check col-7 ">
                        <input type="checkbox" class="form-check-input" id="finalCheckM" required>
                        <label class="form-check-label" for="finalCheckM">Los datos del lugar son correctos </label>
                    </div>
                </div>
                <div class="col-12 ml-4">
                    <button type="submit" class="btn btn-primary col-6">Añadir un lugar</button>
                </div>
            </form>
            
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>