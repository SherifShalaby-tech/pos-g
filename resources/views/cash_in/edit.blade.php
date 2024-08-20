<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('CashInController@update', $cash_in->id), 'method' => 'put', 'id' =>
        'add_cash_in_form',
        'files' => true
        ]) !!}

        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <h4 class="modal-title">@lang( 'lang.add_cash_in' )</h4>
            <button type="button"
                class="btn text-primary rounded-circle d-flex justify-content-center align-items-center modal-close-btn"
                data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="col-md-12">
                <div class="row">
                    <input type="hidden" name="cash_register_id" value="{{$cash_in->cash_register_id}}">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('amount', __( 'lang.amount' ) . ':*') !!}
                            {!! Form::text('amount', @num_format($cash_in->amount), ['class' => 'form-control',
                            'placeholder' =>
                            __(
                            'lang.amount' ), 'required' ])
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('source_id', __('lang.receiver'), []) !!}
                            {!! Form::select('source_id', $users,
                            $cash_in->source_id, ['class' => 'selectpicker form-control', 'data-live-search'=>"true",
                            'placeholder' => __('lang.please_select')]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('notes', __('lang.notes'), []) !!}
                            {!! Form::textarea('notes',
                            $cash_in->notes, ['class' => 'form-control',
                            'placeholder' => __('lang.notes'), 'rows' => 3]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-md-6 px-0 m-0 rounded-0
                 text-center">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-md-6 px-0 m-0 rounded-0 text-center"
                data-dismiss="modal">@lang('lang.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $('.selectpicker').selectpicker('render')
</script>
