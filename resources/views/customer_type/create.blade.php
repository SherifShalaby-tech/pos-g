@extends('layouts.app')
@section('title', __('lang.customer_type'))
@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>

                    <h4>@lang('lang.add_customer_type')</h4>

                </x-page-title>
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <p class="italic mb-0"><small>@lang('lang.required_fields_info')</small></p>
                        </div>
                    </div>
                </div>
                {!! Form::open(['url' => action('CustomerTypeController@store'), 'id' =>
                'customer-type-form',
                'method' =>
                'POST', 'class' => '', 'enctype' => 'multipart/form-data']) !!}
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('name', __( 'lang.name' ),[
                                    'class' =>"locale_label mb-1 field_required"
                                    ]) !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __(
                                    'lang.name' ), 'required' ])
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('store', __( 'lang.store' ),[
                                    'class' =>"locale_label mb-1 field_required"
                                    ]) !!}
                                    {!! Form::select('stores[]', $stores, false, ['class' => 'selectpicker
                                    form-control', 'data-live-search' => "true", 'multiple', 'required']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="submit" value="{{trans('lang.submit')}}" id="submit-btn"
                                        class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</section>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).on('click', '.remove_row', function (){
        $(this).closest('tr').remove();
    })

    $(document).on('click', '.add_row_point', function(){
        var row_id = parseInt($('#row_id_point').val()) + 1;
        $.ajax({
            method: 'get',
            url: '/customer-type/get-product-point-row?row_id='+row_id,
            data: {  },
            contentType: 'html',
            success: function(result) {
                $('#product_point_table tbody').append(result);
                $('.row_'+row_id).find('.product_id_'+row_id).selectpicker('refresh');
                $('#row_id_point').val(row_id);
            },
        });
    })

    $('#customer-type-form').submit(function(){
        $(this).validate();
        if($(this).valid()){
            $(this).submit();
        }
    })
</script>
@endsection
