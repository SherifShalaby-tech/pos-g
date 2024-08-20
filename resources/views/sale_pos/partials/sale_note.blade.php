<!-- order_sale_note modal -->
<div id="sale_note_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div
                class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title">@lang('lang.sale_note')</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i
                            class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('sale_note', __( 'lang.sale_note' ) . ':') !!}
                    <textarea rows="3" class="form-control" name="sale_note_draft"
                        id="sale_note_draft">{{!empty($transaction)? $transaction->sale_note: ''}}</textarea>
                </div>
                <div class="modal-footer">
                    <button data-method="draft" type="button" class="btn btn-primary col-md-6 px-0 m-0 rounded-0
                 text-center" id="draft-btn"><i class="dripicons-flag"></i>
                        @lang('lang.save')</button>
                </div>
            </div>
        </div>
    </div>
</div>
