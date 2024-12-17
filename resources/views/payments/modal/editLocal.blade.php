<div class="modal fade" id="editarModal{{ $local->local_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Editar local</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario" action="{{ route('local.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="merchant_id" id="merchant_id{{ $local->local_id }}" value="{{ $local->merchant_id }}">
                    <input type="hidden" name="local_id" id="local_id{{ $local->local_id }}" value="{{ $local->local_id }}">
                    
                    <div class="d-flex justify-content-start row ">
                        <div class="mb-3 col-12 border">
                            <label for="location" class="form-label">@if ($local->category_id == 1)
                                    Número de local
                                @endif 
                                @if ($local->category_id == 2)
                                    Ubicación del local
                                @endif 
                                @if ($local->category_id == 3)
                                    Recorrido del comerciante
                                @endif 
                            </label>
                            <input type="text" name="location" class="form-control text-uppercase" value="{{ $local->local_location }}" id="location{{ $local->local_id }}" aria-describedby="locationHelp">
                            <div id="locationHelp" class="form-text">Ubicación del local.</div>
                            @error('location')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-3 border">
                            <label for="dimx" class="form-label">Dimensión X</label>
                            <input type=number step=0.01 name="dimx" autocomplete="off" autofocus="on" min=0.01 value="{{ $local->local_dimx }}"
                                class="form-control" id="dimx" aria-describedby="xHelp" placeholder="X.XX" 
                                required>
                            <div id="xHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                            @error('dimx')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-3 border">
                            <label for="dimy" class="form-label">Dimensión Y</label>
                            <input type=number step=0.01 name="dimy" autocomplete="off" autofocus="off" min=0.01 value="{{ $local->local_dimy }}"
                                class="form-control" id="dimy" aria-describedby="yHelp" placeholder="X.XX" 
                                required>
                            <div id="yHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                            @error('dimy')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-3 border" @if ($local->category_id == 1) hidden @endif>
                            <label for="IHour" class="form-label"> Selecciona la hora de inicio. </label>
                            <input type="time" class="form-control" id="IHour" name="IHour" value="{{ $local->local_startingHour }}"
                                @if ($local->category_id == 1)value="00:00" disable required @endif 
                                aria-describedby="iHourHelp" >
                            <div id="iHourHelp" class="form-text">Formato: 12 horas (07:00 a.m.). </div>
                        </div>
                        <div class="mb-3 col-3 border" @if ($local->category_id == 1) hidden @endif>
                            <label for="FHour" class="form-label"> Selecciona la hora de finalización. </label>
                            <input type="time" class="form-control" id="FHour" name="FHour" value="{{ $local->local_endingHour }}"
                                @if ($local->category_id == 1)value="00:00" disable required @endif 
                                aria-describedby="fHourHelp" > 
                            <div id="fHourHelp" class="form-text">Formato: 12 horas (04:00 p.m.).</div>
                        </div>
                        
                    </div>
                    <div class="mb-3 col-10 ">
                        <div class="mb-3 ml-10 form-check ">
                            <input type="checkbox" class="form-check-input" id="Check{{ $local->local_id }}" required>
                            <label class="form-check-label" for="Check{{ $local->local_id }}">Los datos son correctos</label>
                        </div>
                        <button class="btn btn-primary col-3 " id="btn{{ $local->local_id }}">Actualizar datos del local</button> 
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>
