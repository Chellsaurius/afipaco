<div class="modal fade" id="actualizarTianguis{{ $tiangui->tiangui_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTianguisLabel">Actualizar los datos del tianguis </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                <form action="{{ route('tianguis.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="tiangui_id" value="{{ $tiangui->tiangui_id }}">
                    <div class="d-flex justify-content-between row ">
                        <div class="mb-3 col-12 border">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control text-uppercase" value="{{ $tiangui->tiangui_name }}" id="name" aria-describedby="nameHelp">
                            <div id="nameHelp" class="form-text">Nombres del tianguis. </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 p-3 border align-items-center d-flex justify-content-left">
                            <label for="dia" class="form-label">Día del tianguis: </label>
                            <select name="dia" id="dia" class="form-control text-uppercase" >
                                @for ($day = 1; $day <= 7; $day++)
                                    <option value="{{ $day }}" {{ $tiangui->tiangui_day == $day ? 'selected' : '' }} class="text-uppercase">
                                        {{ $daysOfWeek[$day - 1] }}
                                    </option>
                                @endfor
                            </select>
                            
                        </div>
                        <br>
                        <div class="mb-3 col-6 border">
                            <label for="IHour" class="form-label"> Selecciona la hora de inicio. </label>
                            <input type="time" name="IHourTianguis" value="{{ $tiangui->tiangui_startingHour }}" class="form-control"
                            aria-describedby="iHourHelp" min="01:00" max="23:59" required>
                        <div id="iHourHelp" class="form-text">Formato: 24 horas. </div>
                        </div>
                        <div class="mb-3 col-6 border">
                            <label for="IHour" class="form-label"> Selecciona la hora de finalización. </label>
                            <input type="time" name="FHourTianguis" value="{{ $tiangui->tiangui_endingHour }}" class="form-control"
                            aria-describedby="fHourHelp" min="01:00" max="23:59" required>
                        <div id="fHourHelp" class="form-text">Formato: 24 horas. </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                    
                </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>