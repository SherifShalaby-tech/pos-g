<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <h4 class="modal-title">@lang( 'lang.earning_of_point_system' )</h4>
            <button type="button"
                class="btn text-primary rounded-circle d-flex justify-content-center align-items-center modal-close-btn"
                data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <b> {!! Form::label('number', __( 'lang.number' ) . ':') !!} </b> {{$earning_of_point->number}}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <b>{!! Form::label('store_ids', __( 'lang.store' ) . ':') !!}</b> {{implode(', ',
                        $earning_of_point->stores->pluck('name')->toArray())}}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <b>{!! Form::label('customer_type_ids', __( 'lang.customer_type' ) . ':') !!}</b> {{implode(',
                        ', $earning_of_point->customer_types->pluck('name')->toArray())}}

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <b>{!! Form::label('product_ids', __( 'lang.product' ) . ':') !!}</b> {{implode(', ',
                        $earning_of_point->products->pluck('name')->toArray())}}

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <b>{!! Form::label('points_on_per_amount', __( 'lang.points_on_per_amount_sale' ) . ':') !!}</b>
                        {{@num_format($earning_of_point->points_on_per_amount)}}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <b>{!! Form::label('start_date', __( 'lang.start_date' ) . ':') !!}</b>
                        @if(!empty($earning_of_point->start_date)){{@format_date($earning_of_point->start_date)}}@endif

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <b>{!! Form::label('expiry_date', __( 'lang.expiry_date' ) . ':') !!}</b>
                        @if(!empty($earning_of_point->end_date)){{@format_date($earning_of_point->end_date)}}@endif

                    </div>
                </div>
            </div>
            <br>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default col-md-12 px-0 m-0 rounded-0 text-center"
                data-dismiss="modal">@lang('lang.close')</button>
        </div>

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
