<div class="modal fade" id="editPlace{{ $lugar->place_id }}" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar el lugar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('local.updatePlace') }}" method="post">
                    @csrf
                    <input type="hidden" name="local_id" value="{{ $local->local_id }}">
                    <input type="hidden" name="place_id" value="{{ $lugar->place_id }}">
                    <div class="col-12 ">
                        <label for="dimx" class="form-label">Dimensión X del lugar </label>
                        <input type="number" value="{{ $lugar->place_dimx }}" step=0.01 name="dimx"
                            autocomplete="off" autofocus="on" min=0.01 class="form-control" id="dimx"
                            aria-describedby="xHelp" placeholder="X.XX" required>
                        <div id="xHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                    </div>
                    <div class="col-12 ">
                        <label for="dimy" class="form-label">Dimensión Y del lugar </label>
                        <input type="number" value="{{ $lugar->place_dimy }}" step=0.01 name="dimy"
                            autocomplete="off" autofocus="off" min=0.01 class="form-control" id="dimy"
                            aria-describedby="yHelp" placeholder="Y.YY" required>
                        <div id="yHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                    </div> <br><br>
                    <div class="col-12 ml-4">
                        <div class="mb-3 form-check col-7 ">
                            <input type="checkbox" class="form-check-input" id="finalCheckPlace{{ $lugar->id_lugar }}" required>
                            <label class="form-check-label" for="finalCheckPlace{{ $lugar->id_lugar }}">Los datos del
                                lugar son correctos </label>
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
