<div class="modal fade" tabindex="-1" role="dialog" id="weighing_scale_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div
                class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title">@lang('lang.weighing_scale')</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i
                            class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('weighing_scale_barcode', __('lang.weighing_scale_barcode') . ':' ) !!}
                            {!! Form::text('weighing_scale_barcode', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary col-md-6 px-0 m-0 rounded-0
                 text-center" id="weighing_scale_submit">@lang('lang.submit')</button>
                <button type="button" class="btn btn-default col-md-6 px-0 m-0 rounded-0 text-center"
                    data-dismiss="modal">@lang('lang.close')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
