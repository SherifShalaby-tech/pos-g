<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('TaxController@store'), 'method' => 'post', 'id' => $quick_add ?
        'quick_add_tax_form' : 'tax_add_form']) !!}

        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <h4 class="modal-title">@lang('lang.add_tax')</h4>
            <button type="button"
                class="btn text-primary rounded-circle d-flex justify-content-center align-items-center modal-close-btn"
                data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __('lang.name') . ':*') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('lang.name'), 'required'])
                !!}
            </div>
            <input type="hidden" name="quick_add" value="{{ $quick_add }}">
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="form-group">
                {!! Form::label('rate', __('lang.rate_percentage') . ':*') !!}
                {!! Form::text('rate', null, ['class' => 'form-control', 'placeholder' => __('lang.rate'), 'required'])
                !!}
            </div>
            @if ($type == 'general_tax')
            <div class="form-group">
                {!! Form::label('tax_method', __('lang.tax_method') . ':*') !!}
                {!! Form::select('tax_method', ['inclusive' => __('lang.inclusive'), 'exclusive' =>
                __('lang.exclusive')], false, ['class' => 'selectpicker form-control', 'data-live-search' => 'true',
                'placeholder' => __('lang.please_select')]) !!}
            </div>
            <div class="col-md-4">
                <div class="i-checks">
                    <input id="status" name="status" type="checkbox" checked value="1" class="form-control-custom">
                    <label for="status">
                        <strong>
                            @lang('lang.active')
                        </strong>
                    </label>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('store_ids', __('lang.stores') . ':', []) !!} <i class="dripicons-question"
                    data-toggle="tooltip" title="@lang('lang.tax_status_info')"></i>
                {!! Form::select('store_ids[]', $stores, [], ['class' => 'selectpicker form-control', 'data-live-search'
                => 'true', 'data-actions-box' => 'true', 'multiple']) !!}
            </div>
            @endif
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-md-6 px-0 m-0 rounded-0
                 text-center">@lang('lang.save')</button>
            <button type="button" class="btn btn-default col-md-6 px-0 m-0 rounded-0 text-center"
                data-dismiss="modal">@lang('lang.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $('.selectpicker').selectpicker('refresh');
</script>
