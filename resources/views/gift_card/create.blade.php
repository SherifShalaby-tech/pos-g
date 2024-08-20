<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('GiftCardController@store'), 'method' => 'post', 'id' => $quick_add ?
        'quick_add_gift_card_form' : 'gift_card_add_form' ]) !!}

        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <h4 class="modal-title">@lang( 'lang.generate_gift_card' )</h4>
            <button type="button"
                class="btn text-primary rounded-circle d-flex justify-content-center align-items-center modal-close-btn"
                data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('card_number', __( 'lang.card_number' ) . ':*') !!}
                <div class="input-group">
                    {!! Form::text('card_number', $code, ['class' => 'form-control', 'placeholder' => __(
                    'lang.card_number' ), 'required' ])
                    !!}
                    {{-- <div class="input-group-append">
                        <button type="button" class="btn btn-default btn-sm refresh_code"><i
                                class="fa fa-refresh"></i></button>
                    </div> --}}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('amount', __( 'lang.amount' ) . ':*') !!}
                {!! Form::text('amount', null, ['class' => 'form-control', 'placeholder' => __( 'lang.amount' ),
                'required' ])
                !!}
            </div>

            <div class="form-group">
                {!! Form::label('expiry_date', __( 'lang.expiry_date' ) . ':*') !!}
                {!! Form::text('expiry_date', null, ['class' => 'form-control datepicker', 'placeholder' => __(
                'lang.expiry_date' )])
                !!}
            </div>
            <input type="hidden" name="quick_add" value="{{$quick_add }}">
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
    $('.datepicker').datepicker({
        language: '{{session('language')}}',
        todayHighlight: true,
    });
    $('.refresh_code').click()
    $(document).on('click', '.refresh_code', function(){
        $.ajax({
            method: 'get',
            url: '/gift_card-code',
            data: {  },
            success: function(result) {
                $('#card_number').val(result);
            },
        });
    })
</script>
