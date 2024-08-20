<!-- order_discount modal -->
<div role="document" class="modal-dialog">
    <div class="modal-content">
        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <h5 class="modal-title">{{ $dining_table->name }}</h5>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i
                        class="dripicons-cross"></i></span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('table_status', __('lang.status') . ':*') !!}
                {!! Form::select('table_status', $status_array, 'order', ['class' => 'form-control selectpicker',
                'data-live-search' => 'true', 'placeholder' => __('lang.please_select')]) !!}
            </div>
            <div class="row reserve_div hide">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('table_customer_name', __('lang.customer_name') . ':*') !!}
                        {!! Form::text('table_customer_name', $dining_table->customer_name, ['class' => 'form-control',
                        'placeholder' => __('lang.customer_name'), 'required']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('table_customer_mobile_number', __('lang.mobile_number') . ':*') !!}
                        {!! Form::text('table_customer_mobile_number', $dining_table->customer_mobile_number, ['class'
                        => 'form-control', 'placeholder' => __('lang.mobile_number'), 'required']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('table_date_and_time', __('lang.date_and_time') . ':*') !!}
                        <input type="datetime-local" id="table_date_and_time" name="table_date_and_time"
                            value="@if (!empty($dining_table->date_and_time)){{ Carbon\Carbon::parse($dining_table->date_and_time)->format('Y-m-d\TH:i') }}@else{{ date('Y-m-d\TH:i') }}@endif"
                            class="form-control">
                    </div>
                </div>
            </div>
            <input type="hidden" name="discount_amount" id="discount_amount">
            <div class="modal-footer">
                <button type="button" name="discount_btn" id="table_action_btn" class="btn btn-primary col-md-6 px-0 m-0 rounded-0
                 text-center">@lang('lang.save')</button>
                <button type="button" class="btn btn-default col-md-6 px-0 m-0 rounded-0 text-center"
                    data-dismiss="modal">@lang('lang.cancel')</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#table_status').change();
    $('#table_status').selectpicker('render');
</script>
