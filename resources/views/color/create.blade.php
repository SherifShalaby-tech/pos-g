<div class="modal-dialog" role="document">
    <div class="modal-content">
        {!! Form::open(['url' => action('ColorController@store'), 'method' => 'post', 'id' => $quick_add ?
        'quick_add_color_form' : 'color_add_form' ]) !!}

        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <h4 class="modal-title">@lang( 'lang.add_color' )</h4>
            <button type="button"
                class="btn text-primary rounded-circle d-flex justify-content-center align-items-center modal-close-btn"
                data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="form-group col-md-6 px-3">
                {!! Form::label('name', __( 'lang.name' ) . '*' ,[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                ]) !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __( 'lang.name' ), 'required'
                ])
                !!}
            </div>
            <input type="hidden" name="quick_add" value="{{$quick_add }}">
            <div class="form-group col-md-6 px-3">
                {!! Form::label('color_hex', __( 'lang.color_hex' ) . '*',[
                'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                ]) !!}
                {!! Form::text('color_hex', null, ['class' => 'form-control', 'placeholder' => __( 'lang.color_hex' )
                ])
                !!}
            </div>
        </div>

        <div class="modal-footer border-0 p-0 ">
            <button type="button" class="btn btn-default col-md-6 px-0 m-0 rounded-0 text-center"
                data-dismiss="modal">@lang('lang.close')</button>
            <button type="submit" class="btn btn-primary col-md-6 px-0 m-0 rounded-0
                 text-center">@lang( 'lang.save' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
