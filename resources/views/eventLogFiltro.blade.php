<div class="modal fade" id="filtro">
    <div class="modal-dialog modal-dialog-centered modal">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Logs de Eventos - Filtros</span>
            </div>


            <div class="modal-body">
            <div class="form-row border border-dark rounded col-md-12 pl-5 pr-5 pt-1 pb-3 ml-0">

                <div class="col-md-6">
                {!! Form::label("dataEventosDe", "Data Logs Inicial:"      , ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::date("dataEventosDe" , request('dataEventosDe') ?? now()->firstOfMonth(), ["class"=>"form-control"]) !!}
                </div>

                <div class="col-md-6">
                {!! Form::label("dataEventosAte", "Data Logs Final:"      , ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::date("dataEventosAte" , request('dataEventosAte') ?? now()->endOfMonth(), ["class"=>"form-control" ]) !!}
                </div>

            </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="filter-canc-btn" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-sm btn-secondary" id="filter-conf-btn">Filtrar</button>
            </div>
        </div>
    </div>
</div>

