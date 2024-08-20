<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('TutorialController@update', $tutorial->id), 'method' => 'put', 'id'
        =>'tutorial_add_form', 'files' => true ])
        !!}

        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <h4 class="modal-title">@lang( 'lang.edit_tutorial' )</h4>
            <button type="button"
                class="btn text-primary rounded-circle d-flex justify-content-center align-items-center modal-close-btn"
                data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('tutorial_category_id', __( 'lang.content' ) . ':*') !!}
                {!! Form::select('tutorial_category_id', $tutorial_categories, $tutorial->tutorial_category_id, ['class'
                => 'form-control
                selectpicker', 'data-live-search' => 'true', 'placeholder' => __('lang.please_select')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('name', __( 'lang.name' ) . ':*') !!}
                {!! Form::text('name', $tutorial->name, ['class' => 'form-control', 'placeholder' => __( 'lang.name' ),
                'required'
                ])
                !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', __( 'lang.description' )) !!}
                {!! Form::textarea('description', $tutorial->description, ['class' => 'form-control', 'placeholder' =>
                __(
                'lang.description' )
                ])
                !!}
            </div>
            <div class="form-group">
                {!! Form::label('link', __( 'lang.link' ) . ':*') !!}
                {!! Form::text('link', $tutorial->link, ['class' => 'form-control', 'placeholder' => __( 'lang.link' ),
                'required'
                ])
                !!}
            </div>
            {{-- <div class="form-group">
                {!! Form::label('video', __( 'lang.video' )) !!} <br>
                {!! Form::file('video', null, ['class' => '', 'required'
                ]);
                !!}
            </div>
            <div class="form-group">
                {!! Form::label('thumbnail', __( 'lang.thumbnail' )) !!} <br>
                {!! Form::file('thumbnail', null, ['class' => '', 'required'
                ]);
                !!}
            </div> --}}

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-md-6 px-0 m-0 rounded-0
                 text-center">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-md-6 px-0 m-0 rounded-0 text-center"
                data-dismiss="modal">@lang('lang.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
    $('.selectpicker').selectpicker('refresh');
</script>
