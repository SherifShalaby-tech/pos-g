<div class="payment-options row table_room_hide px-2 d-flex flex-column card"
    style=" width: @if (session('system_mode') == 'pos' || session('system_mode') == 'garments' || session('system_mode') == 'supermarket') 100%; @else 50%; @endif">
    {{-- <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="card" type="button" class="btn btn-custom payment-btn"
            data-toggle="modal" data-target="#add-payment" id="credit-card-btn"><i class="fa fa-credit-card"></i>
            @lang('lang.card')</button>
    </div> --}}
    <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="cash" type="button"
            class="btn btn-custom btn-primary payment-btn" data-toggle="modal" data-target="#add-payment"
            data-backdrop="static" data-keyboard="false" id="cash-btn"><i class="fa fa-money"></i>
            @lang('lang.pay')</button>
    </div>
    <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="coupon" type="button" class="btn btn-custom btn-primary"
            data-toggle="modal" data-target="#coupon_modal" id="coupon-btn"><i class="fa fa-tag"></i>
            @lang('lang.coupon')</button>
    </div>
    @if (session('system_mode') != 'restaurant')
    <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="paypal" type="button"
            class="btn btn-custom btn-primary payment-btn" data-toggle="modal" data-target="#add-payment"
            data-backdrop="static" data-keyboard="false" id="paypal-btn"><i class="fa fa-paypal"></i>
            @lang('lang.other_online_payments')</button>
    </div>
    @endif
    <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="draft" type="button" data-toggle="modal"
            data-target="#sale_note_modal" class="btn btn-custom btn-primary"><i class="dripicons-flag"></i>
            @lang('lang.draft')</button>
    </div>
    <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="draft" type="button" class="btn btn-custom btn-primary"
            id="view-draft-btn" data-href="{{ action('SellPosController@getDraftTransactions') }}"><i
                class="dripicons-flag"></i>
            @lang('lang.view_draft')</button>
    </div>
    <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="online-order" type="button"
            class="btn btn-custom btn-primary" id="view-online-order-btn"
            data-href="{{ action('SellPosController@getOnlineOrderTransactions') }}"><img
                src="{{ asset('images/online_order.png') }}" style="height: 25px; width: 35px;" alt="icon">
            @lang('lang.online_orders') <span class="badge badge-danger online-order-badge">0</span></button>
    </div>
    {{-- <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="cheque" type="button"
            class="btn btn-custom btn-primary payment-btn" data-toggle="modal" data-target="#add-payment"
            id="cheque-btn"><i class="fa fa-money"></i>
            @lang('lang.cheque')</button>
    </div>
    <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="bank_transfer" type="button"
            class="btn btn-custom btn-primary payment-btn" data-toggle="modal" data-target="#add-payment"
            id="bank-transfer-btn"><i class="fa fa-building-o"></i>
            @lang('lang.bank_transfer')</button>
    </div> --}}
    <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="pay-later" type="button"
            class="btn btn-custom btn-primary" id="pay-later-btn"><i class="fa fa-hourglass-start"></i>
            @lang('lang.pay_later')</button>
    </div>
    {{-- <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="gift_card" type="button"
            class="btn btn-custom btn-primary payment-btn" data-toggle="modal" data-target="#add-payment"
            id="gift-card-btn"><i class="fa fa-credit-card-alt"></i>
            @lang('lang.gift_card')</button>
    </div> --}}
    {{-- <div class="my-1 w-100">
        <button style="font-size: 10px!important" data-method="deposit" type="button"
            class="btn btn-custom btn-primary payment-btn" data-toggle="modal" data-target="#add-payment"
            id="deposit-btn"><i class="fa fa-university"></i>
            @lang('lang.use_the_balance')</button>
    </div> --}}
    <div class="my-1 w-100">
        <button style="font-size: 10px!important;background-color: #dc3545!important;border-color: #dc3545!important"
            type="button" class="btn btn-custom btn-danger" id="cancel-btn" onclick="return confirmCancel()"><i
                class="fa fa-close"></i>
            @lang('lang.cancel')</button>
    </div>
    <div class="my-1 w-100">
        <button style="font-size: 10px!important" type="button" class="btn btn-custom btn-primary"
            id="recent-transaction-btn"><i class="dripicons-clock"></i>
            @lang('lang.recent_transactions')</button>
    </div>

</div>
