<div class="modal fade" id="filtro">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Listagem de Boletos - Filtros</span>
            </div>


            <div class="modal-body">
            <div class="form-row border border-dark rounded col-md-12 pl-5 pr-5 pt-1 pb-3 ml-0">

                <div class="col-md-3">
                {!! Form::label("dataTituloDe", "Data Emissão de:"      , ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::date("dataTituloDe" , request('dataTituloDe') ?? now()->subYears(5), ["class"=>"form-control"]) !!}
                </div>

                <div class="col-md-3">
                {!! Form::label("dataTituloAte", "Data Emissão até:"      , ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::date("dataTituloAte" , request('dataTituloAte') ?? now()->today(), ["class"=>"form-control" ]) !!}
                </div>

                <div class="col-md-3">
                {!! Form::label("dataVenctoDe", "Vencimento de:", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::date("dataVenctoDe" , request('dataVenctoDe') ?? now()->subYears(5), ["class"=>"form-control" ]) !!}
                </div>

                <div class="col-md-3">
                {!! Form::label("dataVenctoAte", "Vencimento até:", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::date("dataVenctoAte" , request('dataVenctoAte') ?? now()->addYear(), ["class"=>"form-control"]) !!}
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

