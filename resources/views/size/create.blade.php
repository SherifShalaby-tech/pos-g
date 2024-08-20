<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('SizeController@store'), 'method' => 'post', 'id' => $quick_add ?
        'quick_add_size_form' : 'size_add_form' ]) !!}

        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <h4 class="modal-title">@lang( 'lang.add_size' )</h4>
            <button type="button" class="btn btn-default" data-dismiss="modal">X</button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __( 'lang.name' ) . ':*') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __( 'lang.name' ), 'required'
                ])
                !!}
            </div>
            <input type="hidden" name="quick_add" value="{{$quick_add }}">
            <div class="form-group">
                {!! Form::label('size_code', __( 'lang.size_code' ) . ':*') !!}
                {!! Form::text('size_code', null, ['class' => 'form-control', 'placeholder' => __( 'lang.size_code' )])
                !!}
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
