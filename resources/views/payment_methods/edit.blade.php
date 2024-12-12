<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('PaymentMethodController@update', $payment_method->id), 'method' => 'put' ]) !!}



        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <h4 class="modal-title">@lang( 'lang.edit_payment_method' )</h4>

            <button type="button"
                class="btn text-primary rounded-circle d-flex justify-content-center align-items-center modal-close-btn"
                data-dismiss="modal">&times;</button>
        </div>


        <div class="modal-body row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <div class="col-md-12 px-4">
                <div class="form-group">
                    <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('name', __( 'lang.name' ) ,[
                        'class' => app()->isLocale('ar') ? 'mb-1 label-ar' : 'mb-1 label-en'
                        ]) !!}
                        <span class="text-danger">*</span>
                    </div>
                    {!! Form::text('name', $payment_method->name, ['class' => 'form-control', 'placeholder' => __(
                    'lang.name' ),
                    'required'
                    ])
                    !!}
                </div>
            </div>


        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-6">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-6" data-dismiss="modal">@lang( 'lang.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->