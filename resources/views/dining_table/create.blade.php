<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('DiningTableController@store'), 'method' => 'post', 'id' => 'dining_table_form',
        'files' => true]) !!}

        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <h4 class="modal-title">@lang( 'lang.add_table' )</h4>
            <button type="button"
                class="btn text-primary rounded-circle d-flex justify-content-center align-items-center modal-close-btn"
                data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __('lang.name') . ':*') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('lang.name'), 'required',
                'id' => 'dining_table_name']) !!}
            </div>
            @if (!empty($from_setting))
            <div class="form-group">
                {!! Form::label('dining_room_id', __('lang.dining_room') . ':*') !!}
                {!! Form::select('dining_room_id', $dining_rooms, false, ['class' => 'form-control selectpicker',
                'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select')]) !!}
            </div>
            @else
            <input type="hidden" name="dining_room_id" value="{{ $dining_room->id }}">
            @endif
        </div>

        <div class="modal-footer">
            <button type="button" id="add_dining_table_btn" class="btn btn-primary col-md-6 px-0 m-0 rounded-0
                 text-center">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-md-6 px-0 m-0 rounded-0 text-center"
                data-dismiss="modal">@lang('lang.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $('.selectpicker').selectpicker();
</script>
