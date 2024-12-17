<div class="modal fade" id="updateMerchant{{ $merchant->merchant_curp }}" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="updateMerchant{{ $merchant->merchant_curp }}Label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateMerchant{{ $merchant->merchant_curp }}">Actualizar datos del comerciante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('merchant.update') }}">
                    @csrf
                
                    <div class="d-flex justify-content-between row">
                        <div class="mb-3 col-6 border">
                            <label for="nombre" class="form-label">Nombre(s)</label>
                            <input type="text" name="nombre" value="{{ $merchant->merchant_names }}"
                                class="form-control text-uppercase  @error('nombre') is-invalid @enderror "
                                value="{{ old('nombre') }}" id="nombre" aria-describedby="nombreHelp" autofocus="on"
                                required>
                            <div id="nombreHelp" class="form-text">Ingrese el/los nombres.</div>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-3 border">
                            <label for="curp" class="form-label">CURP</label>
                            <input type="text" name="curp" value="{{ $merchant->merchant_curp ?? '' }}"
                                class="form-control text-uppercase @error('merchant_curp') is-invalid @enderror"
                                value="{{ old('merchant_curp') }}" id="curp" aria-describedby="nameHelp"
                                maxlength="18" required>
                            <div id="curpHelp" class="form-text">Ingrese la CURP.</div>
                            @error('merchant_curp')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-3 border">
                            <label for="rfc" class="form-label">RFC</label>
                            <input type="text" name="merchant_rfc" class="form-control text-uppercase @error('merchant_rfc') 
                                is-invalid @enderror" value="{{ old('merchant_rfc') }}" 
                                maxlength="18" id="rfc" aria-describedby="rfcHelp" required>
                            <div id="rfcHelp" class="form-text">Ingrese la clave RFC.</div>
                            @error('merchant_rfc')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-3 border">
                            <label for="telefono1" class="form-label">Teléfono 1</label>
                            <input type=text name="telefono1"
                                class="form-control @error('telefono1') is-invalid @enderror"
                                value="{{ $merchant->merchant_phone1 ?? '' }}" pattern="[0-9]{10}"
                                onkeypress="return !(event.charCode == 46)" onkeydown="return event.keyCode !== 190"
                                id="telefono1" aria-describedby="telefono1Help">
                            <div id="telefono1Help" class="form-text">Ingrese el teléfono principal.</div>
                            @error('telefono1')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                            <!-- autocomplete="off" -->
                        </div>
                        <div class="mb-3 col-3 border">
                            <label for="telefono2" class="form-label">Teléfono 2 (opcional)</label>
                            <input type=text name="telefono2"
                                class="form-control  @error('telefono2') is-invalid @enderror"
                                value="{{ $merchant->merchant_phone1 ?? 'No registrado' }}" pattern="[0-9]{10}"
                                onkeypress="return !(event.charCode == 46)" onkeydown="return event.keyCode !== 190"
                                id="telefono2" aria-describedby="telefono2Help">
                            <div id="telefono2Help" class="form-text">Ingrese el teléfono alternativo, opcional.</div>
                            @error('telefono2')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-6 border">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type=text name="direccion"
                                class="form-control text-uppercase @error('direccion') is-invalid @enderror"
                                value="{{ $merchant->merchant_address }}" id="direccion" aria-describedby="nameHelp"
                                required>
                            <div id="direccionHelp" class="form-text">Ingrese la dirección personal del comerciante.
                            </div>
                            @error('direccion')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                    </div>

                    <div class="col-12 ml-4">
                        <div class="mb-3 form-check col-5 ">
                            <input type="checkbox" class="form-check-input" id="finalCheck{{ $merchant->merchant_curp }}"
                                required>
                            <label class="form-check-label" for="finalCheck{{ $merchant->merchant_curp }}">Los datos del
                                comerciante son correctos </label>
                        </div>
                    </div>
                    <div class="col-12 ml-4">
                        <button type="submit" class="btn btn-primary col-3">Actualizar datos</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
