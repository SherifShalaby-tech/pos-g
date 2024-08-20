<!-- Modal -->
<div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <h5 class="modal-title" id="edit">@lang('lang.edit')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {!! Form::open(['url' => action('LeaveTypeController@update', $leave_type->id), 'method' => 'put']) !!}
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">@lang('lang.type_name')</label>
                        <input type="text" class="form-control" value="{{$leave_type->name}}" name="name" id="name"
                            required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="number_of_days_per_year">@lang('lang.number_of_days_per_year')</label>
                        <input type="text" class="form-control" value="{{$leave_type->number_of_days_per_year}}"
                            name="number_of_days_per_year" id="number_of_days_per_year">
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-md-6 px-0 m-0 rounded-0
                 text-center">@lang('lang.save')</button>
            <button type="button" class="btn btn-default col-md-6 px-0 m-0 rounded-0 text-center"
                data-dismiss="modal">@lang('lang.close')</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
