<div class="modal fade" id="actualizarLugar{{ $market->market_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-uppercase" id="staticBackdropLabel">Editar el lugar: {{ $market->market_name }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('market.edit') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $market->market_id }}">
                    <div class="col-12 row">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
                            <input type="text" name="name" value="{{ $market->market_name }}" class="form-control text-uppercase" aria-label="Sizing example input" 
                                aria-describedby="marketName" placeholder="Ejemplo: Jardin Xidou" autofocus required>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-6 ">
                            <label for="IHourTianguis" class="form-label"> Selecciona la hora de inicio. </label>
                            <input type="time" id="startingHour" name="startingHour" class="form-control" value="{{ $market->market_startingHour }}"
                                aria-describedby="startingHour" min="00:01" max="23:59" required>
                            <div id="startingHour" class="form-text">Formato: 12 horas. </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-6 ">
                            <label for="FHourTianguis" class="form-label"> Selecciona la hora de finalización. </label>
                            <input type="time" id="endingHour" name="endingHour" class="form-control" value="{{ $market->market_endingHour }}"
                                aria-describedby="endingHour" min="00:01" max="24:00" required>
                            <div id="endingHour" class="form-text">Formato: 12 horas.</div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-12 ms-3">
                            <div class="mb-3 form-check col-12 ">
                                <input type="checkbox" class="form-check-input" id="TFinalCheck" required>
                                <label class="form-check-label" for="TFinalCheck">Los datos del lugar son correctos </label>
                            </div>
                        </div>
                        <div class="col-12 ml-4 ps-4">
                            <button type="submit" class="btn btn-primary col-3">Guardar</button>
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
