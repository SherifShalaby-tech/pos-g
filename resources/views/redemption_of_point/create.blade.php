@extends('layouts.app')
@section('title', __('lang.redemption_of_point_system'))
@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">


                <x-page-title>

                    <h4>@lang('lang.add_redemption_of_point_system')</h4>

                </x-page-title>
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <p class="italic mb-0"><small>@lang('lang.required_fields_info')</small></p>
                        </div>
                    </div>
                </div>
                {!! Form::open(['url' => action('RedemptionOfPointController@store'), 'id' =>
                'customer-type-form',
                'method' =>
                'POST', 'class' => '', 'enctype' => 'multipart/form-data']) !!}
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('store_ids', __( 'lang.store' ) ,['class' =>"locale_label mb-1
                                    field_required"]) !!}
                                    {!! Form::select('store_ids[]', $stores, false, ['class' => 'selectpicker
                                    form-control', 'data-live-search' => "true", 'multiple', 'required',
                                    "data-actions-box"=>"true"]) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('earning_of_point_ids', __( 'lang.earning_of_points' ) ,['class'
                                    =>"locale_label mb-1 field_required"]) !!}
                                    {!! Form::select('earning_of_point_ids[]', $earning_of_points, false, ['class' =>
                                    'selectpicker
                                    form-control', 'data-live-search' => "true", 'multiple', 'required',
                                    "data-actions-box"=>"true"]) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                @include('product_classification_tree.partials.product_selection_tree')
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('value_of_1000_points', __( 'lang.value_of_1000_points' ) ,['class'
                                    =>"locale_label mb-1 field_required"])
                                    !!}
                                    {!! Form::text('value_of_1000_points', 1, ['class' => 'form-control', 'required'])
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('start_date', __( 'lang.start_date' ) ,['class' =>"locale_label
                                    mb-1"]) !!}
                                    {!! Form::text('start_date', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('end_date', __( 'lang.end_date' ) ,['class' =>"locale_label mb-1"])
                                    !!}
                                    {!! Form::text('end_date', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="submit" value="{{trans('lang.submit')}}" id="submit-btn"
                                        class="btn btn-primary">
                                </div>
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
<script src="{{asset('js/product_selection_tree.js')}}"></script>
<script type="text/javascript">
    $('.selectpicker').selectpicker('selectAll');
</script>
@endsection
