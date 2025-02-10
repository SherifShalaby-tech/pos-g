@extends('layouts.app')
@section('title', __('lang.pos'))
@section('style')
<style>
    .btn-group-custom .btn {
        font-size: 13px !important;
        min-width: 13% !important;
        margin: 2px 5px;
        text-align: center !important;
        overflow: initial;
        width: auto !important;
    }

    .checkboxes input[type=checkbox] {
        width: 140%;
        height: 140%;
        accent-color: var(--primary-color);
    }

    /* Styling for the Offcanvas */
    .offcanvas {
        position: fixed;
        top: 0;
        right: -100%;
        width: 300px;
        height: 100%;
        background-color: #f8f9fa;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
        transition: right 0.3s ease;
        z-index: 1050;
        padding: 20px;
        overflow-y: auto;
    }

    .offcanvas.open {
        right: 0;
    }

    /* Backdrop */
    .offcanvas-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        display: none;
    }

    .offcanvas-backdrop.show {
        display: block;
    }

    /* Toggle and Close Buttons */
    .offcanvas-toggle {
        padding: 10px 20px;
        cursor: pointer;
        background-color: var(--primary-color);
        color: white;
        border: none;
        font-size: 16px;
    }

    .offcanvas-close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        cursor: pointer;
        background: none;
        border: none;
        color: black;

    }

    body.offcanvas-open {
        overflow: hidden;
    }
</style>
@endsection
@section('content')
@php
$watsapp_numbers = App\Models\System::getProperty('watsapp_numbers');
@endphp
<section class="forms pos-section no-print">
    <div class="container-fluid px-2">

        <div class="row">
            <audio id="mysoundclip1" preload="auto">
                <source src="{{ asset('audio/beep-timber.mp3') }}">
                </source>
            </audio>
            <audio id="mysoundclip2" preload="auto">
                <source src="{{ asset('audio/beep-07.mp3') }}">
                </source>
            </audio>
            <audio id="mysoundclip3" preload="auto">
                <source src="{{ asset('audio/beep-long.mp3') }}">
                </source>
            </audio>


            <div class="px-1  col-md-7">
                {!! Form::open(['url' => action('SellPosController@store'), 'method' => 'post', 'files' => true, 'class'
                => 'pos-form', 'id' => 'add_pos_form']) !!}


                <div class="card ">

                    <input type="hidden" name="default_customer_id" id="default_customer_id"
                        value="@if (!empty($walk_in_customer)) {{ $walk_in_customer->id }} @endif">
                    <input type="hidden" name="row_count" id="row_count" value="0">
                    <input type="hidden" name="customer_size_id_hidden" id="customer_size_id_hidden" value="">
                    <input type="hidden" name="enable_the_table_reservation" id="enable_the_table_reservation"
                        value="{{ App\Models\System::getProperty('enable_the_table_reservation') }}">
                    <div class="d-flex flex-wrap">
                        <div class="col-md-12 main_settings">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                                        {!! Form::select('store_id', $stores, $store_pos->store_id, ['class' =>
                                        'selectpicker form-control', 'data-live-search' => 'true', 'required',
                                        'style' => 'width: 80%', 'placeholder' => __('lang.please_select')]) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('store_pos_id', __('lang.pos') . ':*', []) !!}
                                        {!! Form::select('store_pos_id', $store_poses, $store_pos->id, ['class'
                                        =>
                                        'selectpicker form-control', 'data-live-search' => 'true', 'required',
                                        'style' => 'width: 80%', 'placeholder' => __('lang.please_select')]) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="hidden" name="setting_invoice_lang" id="setting_invoice_lang"
                                            value="{{ !empty(App\Models\System::getProperty('invoice_lang')) ? App\Models\System::getProperty('invoice_lang') : 'en' }}">
                                        {!! Form::label('invoice_lang', __('lang.invoice_lang') . ':', []) !!}
                                        {!! Form::select('invoice_lang', $languages + ['ar_and_en' => 'Arabic
                                        and
                                        English'], !empty(App\Models\System::getProperty('invoice_lang')) ?
                                        App\Models\System::getProperty('invoice_lang') : 'en', ['class' =>
                                        'form-control selectpicker', 'data-live-search' => 'true']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="hidden" name="exchange_rate" id="exchange_rate" value="1">
                                        <input type="hidden" name="default_currency_id" id="default_currency_id"
                                            value="{{ !empty(App\Models\System::getProperty('currency')) ? App\Models\System::getProperty('currency') : '' }}">
                                        {!! Form::label('received_currency_id', __('lang.received_currency') .
                                        ':',
                                        []) !!}
                                        {!! Form::select('received_currency_id', $exchange_rate_currencies,
                                        !empty(App\Models\System::getProperty('currency')) ?
                                        App\Models\System::getProperty('currency') : null, ['class' =>
                                        'form-control
                                        selectpicker', 'data-live-search' => 'true']) !!}
                                    </div>
                                </div>

                                <div class="col-md-1 px-0">
                                    {!! Form::label('', "tax" ,
                                    []) !!}
                                    <select class="form-control" name="tax_id" id="tax_id">
                                        <option value="">No Tax</option>
                                        @foreach ($taxes as $tax)
                                        <option data-rate="{{ $tax['rate'] }}" @if (!empty($transaction) &&
                                            $transaction->tax_id == $tax['id']) selected @endif
                                            value="{{ $tax['id'] }}">{{ $tax['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="tax_id_hidden" id="tax_id_hidden" value="">
                                    <input type="hidden" name="tax_method" id="tax_method" value="">
                                    <input type="hidden" name="tax_rate" id="tax_rate" value="0">
                                    <input type="hidden" name="tax_type" id="tax_type" value="">
                                </div>

                                <div class="col-md-3 d-flex justify-content-between align-items-end">
                                    <button type="button" class="btn btn-link btn-sm"
                                        style="margin-top: 30px; padding: 0px !important;" data-toggle="modal"
                                        data-target="#delivery-cost-modal"><img src="{{ asset('images/delivery.jpg') }}"
                                            alt="delivery" style="height: 35px; width: 40px;"></button>





                                    @if (session('system_mode') == 'garments')

                                    <button type="button" class="btn btn-default" style="margin-top: 30px;"
                                        data-toggle="modal" data-target="#customer_sizes_modal"><img
                                            style="width: 20px; height: 25px;"
                                            src="{{ asset('images/269 Garment Icon.png') }}"
                                            alt="@lang('lang.customer_size')" data-toggle="tooltip"
                                            title="@lang('lang.customer_size')"></button>
                                    @endif
                                    <button type="button" class="btn btn-primary" style="margin-top: 38px;"
                                        id="print_and_draft"><i class="dripicons-print"></i></button>
                                    <input type="hidden" id="print_and_draft_hidden" name="print_and_draft_hidden"
                                        value="">


                                </div>
                            </div>
                        </div>







                        <div class="col-md-12 main_settings">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex col-md-8 align-items-end px-0 table_room_hide " style="gap: 10px">
                                    <div class="col-md-5 px-0">
                                        <div class="d-flex flex-column">
                                            <div class="text-primary border d-flex justify-content-between align-items-center rounded"
                                                style="padding: 3px;min-width: 100px;">
                                                <label class=" mb-0 text-primary p-1 bg-white rounded"
                                                    style="font-weight:600"
                                                    for="customer_type_name">@lang('lang.customer_type'):</label>
                                                <span style="font-size: 12px !important;font-weight: 600 !important;"
                                                    class="customer_type_name"></span>
                                            </div>
                                            {!! Form::label('customer_id', __('lang.customer'), []) !!}
                                            <div class="input-group my-group">
                                                {!! Form::select('customer_id', $customers, !empty($walk_in_customer) ?
                                                $walk_in_customer->id : null, ['class' => 'selectpicker form-control',
                                                'data-live-search' => 'true', 'style' => 'width: 80%', 'id' =>
                                                'customer_id', 'required']) !!}
                                                <span class="input-group-btn">
                                                    @can('customer_module.customer.create_and_edit')
                                                    <a class="btn-modal btn  btn-primary btn-flat"
                                                        data-href="{{ action('CustomerController@create') }}?quick_add=1"
                                                        data-container=".view_modal"><i
                                                            class="fa fa-plus-circle text-white fa-lg"></i></a>
                                                    @endcan
                                                </span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class=" d-flex justify-content-between align-items-center" style="gap: 10px">
                                        <div class="d-flex flex-column" style="gap: 3px;margin-top:2px">
                                            <div class="text-primary border d-flex flex-column justify-content-center align-items-center rounded"
                                                style="padding: 3px;min-width: 70px;">
                                                <label class="text-center text-primary w-100 mb-0 px-3 bg-white rounded"
                                                    style="font-weight:600"
                                                    for="customer_balance">@lang('lang.balance')</label>
                                                <span style="font-size: 12px !important;font-weight: 600 !important;"
                                                    class="customer_balance">{{
                                                    @num_format(0) }}</span>
                                            </div>
                                            <div class="text-primary border d-flex flex-column justify-content-center align-items-center rounded"
                                                style="padding: 3px;min-width: 70px;">
                                                <label class="text-center text-primary w-100 mb-0 px-3 bg-white rounded"
                                                    style="font-weight:600" for="points">@lang('lang.points')</label>

                                                <span style="font-size: 12px !important;font-weight: 600 !important;"
                                                    class="points"><span class="customer_points_span">{{ @num_format(0)
                                                        }}</span></span>
                                                <span class="staff_note small"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-0 text-center">
                                        @if (session('system_mode') == 'pos' || session('system_mode') == 'restaurant')

                                        <button type="button" class=" btn btn-danger mb-1 mt-1 mb-xl-1 w-100"
                                            style="margin-top: 38px;" data-toggle="modal"
                                            data-target="#non_identifiable_item_modal">@lang('lang.non_identifiable_item')</button>

                                        @endif

                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#contact_details_modal">@lang('lang.details')</button>



                                    </div>
                                </div>

                                <div class="d-flex col-md-4 px-1 flex-column align-items-center justify-content-end">

                                    @if (session('system_mode') == 'restaurant')

                                    <button type="button" style="padding: 0px !important;"
                                        data-href="{{ action('DiningRoomController@getDiningModal') }}"
                                        data-container="#dining_model" class="btn btn-modal pull-right mt-4"><img
                                            src="{{ asset('images/black-table.jpg') }}" alt="black-table"
                                            style="width: 40px; height: 33px; margin-top: 7px;"></button>

                                    @endif

                                    <div class="px-0">
                                        <div class="search-box input-group">
                                            <button type="button" class="btn btn-secondary btn-lg" id="search_button"><i
                                                    class="fa fa-search"></i></button>
                                            <input type="text" name="search_product" id="search_product"
                                                placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                                class="form-control ui-autocomplete-input" autocomplete="off">
                                            @if (isset($weighing_scale_setting['enable']) &&
                                            $weighing_scale_setting['enable'])
                                            <button type="button" class="btn btn-default bg-white btn-flat"
                                                id="weighing_scale_btn" data-toggle="modal"
                                                data-target="#weighing_scale_modal"
                                                title="@lang('lang.weighing_scale')"><i
                                                    class="fa fa-balance-scale text-primary fa-lg"></i></button>
                                            @endif
                                            <button type="button" class="btn btn-primary btn-lg btn-modal"
                                                data-href="{{ action('ProductController@create') }}?quick_add=1"
                                                data-container=".view_modal"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row table_room_show hide col-md-12">
                                <div class="col-md-3 d-flex justify-content-center align-items-center">
                                    <div class="w-100"
                                        style="padding: 5px 5px; background:#0082ce; color: #fff; font-size: 20px; font-weight: bold; text-align: center; border-radius: 5px;">
                                        <span class="room_name"></span>
                                    </div>
                                </div>


                                <div class="col-md-3 d-flex flex-column">
                                    <label for=""
                                        style="font-size: 20px !important; font-weight: bold; text-align: center; margin-top: 3px;">@lang('lang.table'):
                                        <span class="table_name"></span></label>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group my-group">
                                        {!! Form::select('service_fee_id', $service_fees, null, ['class' =>
                                        'form-control', 'placeholder' => __('lang.select_service'), 'id' =>
                                        'service_fee_id']) !!}
                                    </div>
                                </div>
                                <input type="hidden" name="service_fee_id_hidden" id="service_fee_id_hidden" value="">
                                <input type="hidden" name="service_fee_rate" id="service_fee_rate" value="0">
                                <input type="hidden" name="service_fee_value" id="service_fee_value" value="0">
                            </div>

                            <div class="col-md-12" style="margin-top: 5px; padding: 0px; ">
                                <div class="table-responsive transaction-list">
                                    <table id="product_table" style="width: 100% "
                                        class="table table-hover table-striped order-list table-fixed">
                                        <thead>
                                            <tr>
                                                <th
                                                    style="width: @if (session('system_mode') != 'restaurant') 18% @else 20% @endif; font-size: 12px !important;">
                                                    @lang('lang.product')</th>
                                                <th
                                                    style="width: @if (session('system_mode') != 'restaurant') 16% @else 20% @endif; font-size: 12px !important;">
                                                    @lang('lang.quantity')</th>
                                                <th
                                                    style="width: @if (session('system_mode') != 'restaurant') 14% @else 15% @endif; font-size: 12px !important;">
                                                    @lang('lang.price')</th>
                                                <th
                                                    style="width: @if (session('system_mode') != 'restaurant') 11% @else 15% @endif; font-size: 12px !important;">
                                                    @lang('lang.discount')</th>
                                                <th
                                                    style="width: @if (session('system_mode') != 'restaurant') 12% @else 15% @endif; font-size: 12px !important;">
                                                    @lang('lang.category_discount')</th>
                                                <th
                                                    style="width: @if (session('system_mode') != 'restaurant') 9% @else 15% @endif; font-size: 12px !important;">
                                                    @lang('lang.sub_total')</th>
                                                @if (session('system_mode') != 'restaurant')
                                                <th
                                                    style="width: @if (session('system_mode') != 'restaurant') 9% @else 15% @endif; font-size: 12px !important;">
                                                    @lang('lang.current_stock')</th>
                                                @endif
                                                <th
                                                    style="width: @if (session('system_mode') != 'restaurant') 9% @else 15% @endif; font-size: 12px !important;">
                                                    @lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="hidden" id="final_total" name="final_total" />
                                        <input type="hidden" id="grand_total" name="grand_total" />
                                        <input type="hidden" id="gift_card_id" name="gift_card_id" />
                                        <input type="hidden" id="coupon_id" name="coupon_id">
                                        <input type="hidden" id="total_tax" name="total_tax" value="0.00">
                                        <input type="hidden" id="total_item_tax" name="total_item_tax" value="0.00">
                                        <input type="hidden" id="status" name="status" value="final" />
                                        <input type="hidden" id="total_sp_discount" name="total_sp_discount"
                                            value="0" />
                                        <input type="hidden" id="total_pp_discount" name="total_pp_discount"
                                            value="0" />
                                        <input type="hidden" name="dining_table_id" id="dining_table_id" value="">
                                        <input type="hidden" name="dining_action_type" id="dining_action_type" value="">
                                    </div>
                                </div>
                            </div>




                            <div class="col-12 px-1 totals table_room_hide dev_not_room" style=" padding-top: 10px;">
                                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif justify-content-center align-items-center"
                                    style="gap: 2px">

                                    <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
                                        style="padding: 5px;min-width: 100px;">
                                        <span class="totals-title text-center text-primary w-100 px-3 bg-white rounded"
                                            style="font-weight:600">{{ __('lang.items') }}</span>

                                        <span id="item">0</span>
                                    </div>

                                    <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
                                        style="padding: 5px;min-width: 100px;">
                                        <span class="totals-title text-center text-primary w-100 px-3 bg-white rounded"
                                            style="font-weight:600">{{
                                            __('lang.quantity') }}</span>
                                        <span id="item-quantity">0</span>
                                    </div>
                                    <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
                                        style="padding: 5px;min-width: 100px;">
                                        <span class="totals-title text-center text-primary w-100 px-3 bg-white rounded"
                                            style="font-weight:600">{{ __('lang.total') }}</span><span
                                            id="subtotal">0.00</span>
                                    </div>


                                    <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
                                        style="padding: 5px;min-width: 100px;">
                                        <span class="totals-title text-center text-primary w-100 px-3 bg-white rounded"
                                            style="font-weight:600">{{ __('lang.tax') }} </span><span
                                            id="tax">0.00</span>
                                    </div>
                                    <div class="bg-primary text-white d-flex flex-column justify-content-center align-items-center rounded"
                                        style="padding: 5px;min-width: 100px;">
                                        <span class="totals-title text-center text-primary w-100 px-3 bg-white rounded"
                                            style="font-weight:600">{{ __('lang.delivery') }}</span><span
                                            id="delivery-cost">0.00</span>
                                    </div>
                                    <div class="bg-primary red text-white d-flex flex-column justify-content-center align-items-center rounded"
                                        style="padding: 5px;min-width: 100px;">
                                        <span class="totals-title text-center text-primary w-100 px-3 bg-white rounded"
                                            style="font-weight:600">{{ __('lang.sales_promotion')
                                            }}</span><span id="sales_promotion-cost_span">0.00</span>
                                    </div>

                                    <div class="payment-amount col-md-3 table_room_hide dev_not_room bg-primary text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                        style="
                                        display: flex;
                                        height: fit-content;
                                        align-items: center;
                                        justify-content: space-between;
                                        font-weight: 700;
                                        font-size: 18px;
                                        border-radius: 5px;
                                        padding: 12px 10px;">
                                        <span class="">{{ __('lang.grand_total') }}
                                        </span>
                                        <span class="final_total_span">0.00</span>
                                    </div>
                                </div>
                            </div>




                            <div class="col-md-12 table_room_show hide"
                                style="border-top: 2px solid #e4e6fc; margin-top: 10px;">
                                <div class="row">

                                    <div class="col-md-12 row justify-content-center align-items-center">
                                        <div class="row col-md-3 justify-content-center align-items-center">
                                            <b>@lang('lang.total'): <span class="subtotal">0.00</span></b>
                                        </div>
                                        <div class="row col-md-3 justify-content-center align-items-center">
                                            <b>@lang('lang.discount'): <span class="discount_span">0.00</span></b>
                                        </div>
                                        <div class="row col-md-3 justify-content-center align-items-center">
                                            <b>@lang('lang.service'): <span class="service_value_span">0.00</span></b>
                                        </div>
                                        <div class="row col-md-3 justify-content-center align-items-center">
                                            <b>@lang('lang.grand_total'): <span class="final_total_span">0.00</span></b>
                                        </div>

                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-md-12">
                                        <div class="row justify-content-center">
                                            <button type="button" name="action" value="print" id="dining_table_print"
                                                class="btn py-2 col-md-2 mr-2 btn-primary text-white">@lang('lang.print')</button>
                                            <button type="button" name="action" value="save" id="dining_table_save"
                                                class="btn py-2 col-md-2 mr-2 text-white btn-primary">@lang('lang.save')</button>
                                            <button data-method="cash" type="button"
                                                class="btn py-2 col-md-2 mr-2 btn-primary payment-btn text-white"
                                                data-toggle="modal" data-target="#add-payment" data-backdrop="static"
                                                data-keyboard="false" id="cash-btn">@lang('lang.pay_and_close')</button>
                                            @if(auth()->user()->can('sp_module.sales_promotion.view')
                                            || auth()->user()->can('sp_module.sales_promotion.create_and_edit')
                                            || auth()->user()->can('sp_module.sales_promotion.delete'))
                                            <button type="button"
                                                class="btn py-2 col-md-2 mr-2 btn-md btn-primary payment-btn text-white"
                                                data-toggle="modal"
                                                data-target="#discount_modal">@lang('lang.random_discount')</button>
                                            @endif

                                            <button type="button" class="btn py-2 col-md-2 btn-danger text-white"
                                                id="cancel-btn" onclick="return confirmCancel()">
                                                @lang('lang.cancel')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    {{-- <div class="payment-amount table_room_hide">
                        <h2 class="bg-primary text-white">{{ __('lang.grand_total') }} <span
                                class="final_total_span">0.00</span></h2>
                    </div> --}}
                    @php
                    $default_invoice_toc = App\Models\System::getProperty('invoice_terms_and_conditions');
                    if (!empty($default_invoice_toc)) {
                    $toc_hidden = $default_invoice_toc;
                    } else {
                    $toc_hidden = array_key_first($tac);
                    }
                    @endphp

                    @include('sale_pos.includes.payment')
                    <input type="hidden" name="terms_and_condition_hidden" id="terms_and_condition_hidden"
                        value="{{ $toc_hidden }}">

                    <div
                        class="d-flex col-12 px-1 mt-1 justify-content-between align-items-start @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif table_room_hide ">

                        <div class="col-md-3 px-1">
                            <div class="form-group">
                                {!! Form::label('terms_and_condition_id',
                                __('lang.terms_and_conditions'),
                                [])
                                !!}
                                <select name="terms_and_condition_id" id="terms_and_condition_id"
                                    class="form-control selectpicker" data-live-search="true">
                                    <option value="">@lang('lang.please_select')</option>
                                    @foreach ($tac as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="tac_description_div"><span></span></div>
                        </div>
                        <div class="col-md-3 px-1">
                            <div class="form-group">
                                {!! Form::label('commissioned_employees',
                                __('lang.commissioned_employees'),
                                [])
                                !!}
                                {!! Form::select('commissioned_employees[]', $employees, false, ['class'
                                =>
                                'form-control selectpicker', 'data-live-search' => 'true', 'multiple',
                                'id'
                                =>
                                'commissioned_employees']) !!}
                            </div>
                        </div>
                        <div class=" d-flex justify-content-center align-items-center hide shared_commission_div">
                            <div class="i-checks toggle-pill-color d-flex flex-column align-items-center">
                                <input id="shared_commission" name="shared_commission" type="checkbox" value="1"
                                    class="form-control-custom">
                                <label for="shared_commission"><strong>
                                        @lang('lang.shared_commission')
                                    </strong></label>
                            </div>
                        </div>



                    </div>



                </div>






                @include('sale_pos.partials.payment_modal')
                @include('sale_pos.partials.discount_modal')
                {{-- @include('sale_pos.partials.tax_modal') --}}
                @include('sale_pos.partials.delivery_cost_modal')
                @include('sale_pos.partials.coupon_modal')
                @include('sale_pos.partials.contact_details_modal')
                @include('sale_pos.partials.weighing_scale_modal')
                @include('sale_pos.partials.non_identifiable_item_modal')
                @include('sale_pos.partials.customer_sizes_modal')
                @include('sale_pos.partials.sale_note')

                {!! Form::close() !!}
            </div>

            <!-- product list -->
            <div class="card m-0 px-1  col-md-5">
                <!-- navbar-->

                <header class="header">
                    <nav class="navbar">
                        <div class="container-fluid">
                            <div class="navbar-holder d-flex align-items-center justify-content-between">

                                <div class="navbar-header">

                                    <ul
                                        class="nav-menu flex-wrap list-unstyled d-flex flex-md-row align-items-md-center">
                                        <li class="nav-item m-0">
                                            <a id="toggle-btn" href="#" class="menu-btn"><i class="fa fa-bars">
                                                </i></a>
                                        </li>
                                        <li class="nav-item m-0">
                                            <a href="{{ action('SellController@create') }}" id="commercial_invoice_btn"
                                                data-toggle="tooltip" data-title="@lang('lang.add_sale')"
                                                class="btn no-print"><img
                                                    src="{{ asset('images/396 Commercial Invoice Icon.png') }}" alt=""
                                                    style="height: 40px; width: 35px;">
                                            </a>
                                        </li>
                                        <li class="nav-item m-0">
                                            <a target="_blank"
                                                href="https://api.whatsapp.com/send?phone={{$watsapp_numbers}}"
                                                id="contact_us_btn" data-toggle="tooltip"
                                                data-title="@lang('lang.contact_us')"
                                                style="background-image:  url('{{asset('images/watsapp.jpg')}}');background-size: 40px;"
                                                class="btn no-print">
                                            </a>
                                            {{-- <a target="_blank"
                                                href="{{ action('ContactUsController@getUserContactUs') }}"
                                                id="contact_us_btn" data-toggle="tooltip"
                                                data-title="@lang('lang.contact_us')"
                                                style="background-image: url('{{ asset('images/handshake.jpg') }}');"
                                                class="btn no-print">
                                            </a> --}}
                                        </li>
                                        <li class="nav-item m-0"><button class="btn-danger btn btn-sm hide"
                                                id="power_off_btn"><i class="fa fa-power-off"></i></button></li>
                                        <li class="nav-item m-0"><a id="btnFullscreen" title="Full Screen"><i
                                                    class="dripicons-expand"></i></a></li>
                                        @include('layouts.partials.notification_list')
                                        @php
                                        $config_languages = config('constants.langs');
                                        $languages = [];
                                        foreach ($config_languages as $key => $value) {
                                        $languages[$key] = $value['full_name'];
                                        }
                                        @endphp
                                        <li class="nav-item m-0">
                                            <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"
                                                class="nav-link dropdown-item"><i class="dripicons-web"></i>
                                                <span>{{ __('lang.language') }}</span> <i
                                                    class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                user="menu">
                                                @foreach ($languages as $key => $lang)
                                                <li>
                                                    <a href="{{ action('GeneralController@switchLanguage', $key) }}"
                                                        class="btn btn-link">
                                                        {{ $lang }}</a>
                                                </li>
                                                @endforeach

                                            </ul>
                                        </li>
                                        <li class="nav-item m-0">
                                            <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"
                                                class="nav-link dropdown-item"><i class="dripicons-user"></i>
                                                <span>{{ ucfirst(Auth::user()->name) }}</span> <i
                                                    class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                user="menu">
                                                @php
                                                $employee = App\Models\Employee::where('user_id',
                                                Auth::user()->id)->first();
                                                @endphp
                                                <li style="text-align: center">
                                                    <img src="@if (!empty($employee->getFirstMediaUrl('employee_photo'))) {{ $employee->getFirstMediaUrl('employee_photo') }}@else{{ asset('images/default.jpg') }} @endif"
                                                        style="width: 60px; border: 2px solid #fff; padding: 4px; border-radius: 50%;" />
                                                </li>
                                                <li>
                                                    <a href="{{ action('UserController@getProfile') }}"><i
                                                            class="dripicons-user"></i>
                                                        @lang('lang.profile')</a>
                                                </li>
                                                @can('settings.general_settings.view')
                                                <li>
                                                    <a href="{{ action('SettingController@getGeneralSetting') }}"><i
                                                            class="dripicons-gear"></i>
                                                        @lang('lang.settings')</a>
                                                </li>
                                                @endcan
                                                <li>
                                                    <a
                                                        href="{{ url('my-transactions/' . date('Y') . '/' . date('m')) }}"><i
                                                            class="dripicons-swap"></i>
                                                        @lang('lang.my_transactions')</a>
                                                </li>
                                                @if (Auth::user()->role_id != 5)
                                                <li>
                                                    <a href="{{ url('my-holidays/' . date('Y') . '/' . date('m')) }}"><i
                                                            class="dripicons-vibrate"></i>
                                                        @lang('lang.my_holidays')</a>
                                                </li>
                                                @endif

                                                <li>
                                                    <a href="#" id="logout-btn"><i class="dripicons-power"></i>
                                                        @lang('lang.logout')
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                    </nav>
                </header>


                @include('sale_pos.partials.right_side')
            </div>

            <!-- recent transaction modal -->
            @include('sale_pos.includes.recent-transaction')

            <!-- draft transaction modal -->
            @include('sale_pos.includes.draft-transaction')

            <!-- onlineOrder transaction modal -->
            @include('sale_pos.includes.online-order')

            <div id="dining_model" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                class="modal text-left">
            </div>
            <div id="dining_table_action_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                class="modal fade text-left">
            </div>
        </div>
    </div>


</section>


<!-- This will be printed -->
<section class="invoice print_section print-only" id="receipt_section"> </section>
@endsection

@section('javascript')
<script src="{{ asset('js/onscan.min.js') }}"></script>
<script src="{{ asset('js/pos.js') }}"></script>
<script src="{{ asset('js/dining_table.js') }}"></script>
<script>
    $(document).ready(function() {
            $('.online-order-badge').hide();
        })
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        var channel = pusher.subscribe('order-channel');
        channel.bind('new-order', function(data) {
            if (data) {
                let badge_count = parseInt($('.online-order-badge').text()) + 1;
                $('.online-order-badge').text(badge_count);
                $('.online-order-badge').show();
                var transaction_id = data.transaction_id;
                $.ajax({
                    method: 'get',
                    url: '/pos/get-transaction-details/' + transaction_id,
                    data: {},
                    success: function(result) {
                        toastr.success(LANG.new_order_placed_invoice_no + ' ' + result.invoice_no);
                        let notification_number = parseInt($('.notification-number').text());
                        console.log(notification_number, 'notification-number');
                        if (!isNaN(notification_number)) {
                            notification_number = parseInt(notification_number) + 1;
                        } else {
                            notification_number = 1;
                        }
                        $('.notification-list').empty().append(
                            `<i class="dripicons-bell"></i><span class="badge badge-danger notification-number">${notification_number}</span>`
                        );
                        $('.notifications').prepend(
                            `<li>
                                <a class="pending notification_item"
                                    data-mark-read-action=""
                                    data-href="{{ url('/') }}/pos/${transaction_id}/edit?status=final">
                                    <p style="margin:0px"><i class="dripicons-bell"></i> ${LANG.new_order_placed_invoice_no} #
                                        ${result.invoice_no}</p>
                                    <span class="text-muted">
                                        @lang('lang.total'): ${__currency_trans_from_en(result.final_total, false)}
                                    </span>
                                </a>

                            </li>`
                        );
                        $('.no_new_notification_div').addClass('hide');

                    },
                });
            }
        });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const offcanvasToggle = document.getElementById('offcanvas-toggle');
    const offcanvasClose = document.getElementById('offcanvas-close');
    const offcanvas = document.getElementById('offcanvas');
    const backdrop = document.getElementById('offcanvas-backdrop');

    offcanvasToggle.addEventListener('click', function() {
    offcanvas.classList.add('open');
    // backdrop.classList.add('show');
    document.body.classList.add('offcanvas-open');
    });

    offcanvasClose.addEventListener('click', function() {
    offcanvas.classList.remove('open');
    // backdrop.classList.remove('show');
    document.body.classList.remove('offcanvas-open');
    });

    backdrop.addEventListener('click', function() {
    offcanvas.classList.remove('open');
    // backdrop.classList.remove('show');
    document.body.classList.remove('offcanvas-open');
    });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.payment-modal-btn');

    buttons.forEach(button => {
    button.addEventListener('click', function () {
 // Get the data attributes
    const methodId = button.getAttribute('data-method-id');
    const methodTypes = JSON.parse(button.getAttribute('data-method-types')); // Parse JSON data

// Target the select element
const paymentSelect = document.querySelector('#payment-method-select');

if (methodId && methodTypes && paymentSelect) {
// Clear existing options
paymentSelect.innerHTML = '';

// Add new options from methodTypes
methodTypes.forEach(type => {
const option = document.createElement('option');
option.value = type; // Set value attribute
option.textContent = type; // Set displayed text
paymentSelect.appendChild(option);
});
}

    });
    });
    });
</script>
@endsection
