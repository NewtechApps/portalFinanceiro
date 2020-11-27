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
                {!! Form::date("dataTituloDe" , request('dataTituloDe') ?? now()->firstOfMonth(), ["class"=>"form-control"]) !!}
                </div>

                <div class="col-md-3">
                {!! Form::label("dataTituloAte", "Data Emissão até:"      , ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::date("dataTituloAte" , request('dataTituloAte') ?? now()->endOfMonth(), ["class"=>"form-control" ]) !!}
                </div>

                <div class="col-md-3">
                {!! Form::label("dataVencDe", "Vencimento de:", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::date("dataVencDe" , request('dataVencDe') ?? now()->firstOfMonth(), ["class"=>"form-control" ]) !!}
                </div>

                <div class="col-md-3">
                {!! Form::label("dataVencAte", "Vencimento até:", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::date("dataVencAte" , request('dataVencAte') ?? now()->endOfMonth(), ["class"=>"form-control"]) !!}
                </div>

                <div class="col-md-5">
                {!! Form::label("municipio","Município",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("municipio", request('municipio'), ["class"=>"form-control", "maxLength"=>'100' ]) !!}
                </div>

                <div class="col-md-1">
                {!! Form::label("estado","UF",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("estado", request('estado'), ["class"=>"form-control", "maxLength"=>'2' ]) !!}
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

