<div class="modal fade" id="editLocalDimentions{{ $local->local_id }}" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar el local</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('local.updateLocalMeasurements') }}" method="post">
                    @csrf
                    <input type="hidden" name="local_id" value="{{ $local->local_id }}">
                    <div class="col-12 ">
                        <label for="dimx" class="form-label">Dimensión X del local </label>
                        <input type="number" value="{{ $local->local_dimx }}" step=0.01 name="dimx"
                            autocomplete="off" autofocus="on" min=0.01 class="form-control" id="dimx"
                            aria-describedby="xHelp" placeholder="X.XX" required>
                        <div id="xHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                    </div>
                    <div class="col-12 ">
                        <label for="dimy" class="form-label">Dimensión Y del local </label>
                        <input type="number" value="{{ $local->local_dimy }}" step=0.01 name="dimy"
                            autocomplete="off" autofocus="off" min=0.01 class="form-control" id="dimy"
                            aria-describedby="yHelp" placeholder="Y.YY" required>
                        <div id="yHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                    </div> <br><br>
                    <div class="col-12 ml-4">
                        <div class="mb-3 form-check col-7 ">
                            <input type="checkbox" class="form-check-input" id="finalCheckPlace{{ $local->local_id }}" required>
                            <label class="form-check-label" for="finalCheckPlace{{ $local->local_id }}">Los datos del
                                local son correctos </label>
                        </div>
                    </div>
                    <div class="col-12 ml-4">
                        <button type="submit" class="btn btn-primary col-6"> Guardar</button>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
