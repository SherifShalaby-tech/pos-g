@extends('layouts.app')
@section('title', __('lang.add_transfer'))

@section('content')
<section class="forms pt-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>
                    <h4>@lang('lang.add_transfer')</h4>
                </x-page-title>

                {!! Form::open(['url' => action('TransferController@store'), 'method' => 'post', 'id' =>
                'add_transfer_form', 'enctype' => 'multipart/form-data' ]) !!}
                <input type="hidden" name="is_raw_material" id="is_raw_material" value="{{ $is_raw_material }}">

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('sender_store_id', __('lang.sender_store'), ['class' =>"locale_label
                                    mb-1 field_required"]) !!}
                                    {!! Form::select('sender_store_id', $stores,
                                    null, ['class' => 'selectpicker form-control', 'data-live-search'=>"true",
                                    'required',
                                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('receiver_store_id', __('lang.receiver_store'), ['class'
                                    =>"locale_label mb-1 field_required"]) !!}
                                    {!! Form::select('receiver_store_id', $stores,
                                    null, ['class' => 'selectpicker form-control', 'data-live-search'=>"true",
                                    'required',
                                    'style' =>'width: 80%' , 'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir align-items-center">
                            <div class="col-md-10">
                                <div class="search-box input-group">
                                    <button type="button" class="btn btn-primary btn-lg" id="search_button"><i
                                            class="fa fa-search"></i></button>
                                    <input type="text" name="search_product" id="search_product"
                                        placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                        class="form-control ui-autocomplete-input" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-2">
                                @include('quotation.partial.product_selection')
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped table-condensed" id="product_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%" class="col-sm-8">@lang( 'lang.products' )</th>
                                            <th style="width: 25%" class="col-sm-4">@lang( 'lang.sku' )</th>
                                            <th style="width: 25%" class="col-sm-4">@lang( 'lang.quantity' )</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.purchase_price' )</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.sub_total' )</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.action' )</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <div class="col-md-12 text-center">

                                <h3> @lang('lang.total'): <span class="final_total_span"></span> </h3>
                                <input type="hidden" name="final_total" id="final_total" value="0">

                            </div>
                        </div>
                    </div>
                </div>


                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('files', __('lang.files'), ['class' =>"locale_label mb-1"]) !!}
                                    {!! Form::file('files[]', null, ['class' => '']) !!}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('notes', __('lang.notes'), ['class' =>"locale_label mb-1"]) !!}
                                    {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3]) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <div class="col-sm-12">
                                <button type="submit" name="submit" id="print" value="save"
                                    class="btn btn-primary pull-right btn-flat submit">@lang( 'lang.save' )</button>
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
<script src="{{asset('js/transfer.js')}}"></script>
<script src="{{asset('js/product_selection.js')}}"></script>
<script type="text/javascript">
    $(document).on('click', '#add-selected-btn', function(){
        $('#select_products_modal').modal('hide');
        $.each(product_selected, function(index, value){
            get_label_product_row(value.product_id, value.variation_id);
        });
        product_selected = [];
        product_table.ajax.reload();
    })
</script>
@endsection
