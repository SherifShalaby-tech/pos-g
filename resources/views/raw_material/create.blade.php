@extends('layouts.app')
@section('title', __('lang.raw_materials'))

@section('content')
<section class="forms pt-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <x-page-title>
                    <h4>@lang('lang.add_new_raw_material')</h4>
                </x-page-title>
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <p class="italic mb-0"><small>@lang('lang.required_fields_info')</small></p>
                    </div>
                </div>
                {!! Form::open(['url' => action('RawMaterialController@store'), 'id' => 'product-form', 'method'
                =>
                'POST', 'class' => '', 'enctype' => 'multipart/form-data']) !!}
                @include('raw_material.partial.create_raw_material_form')
                <input type="hidden" name="active" value="1">
                <div class="row">
                    <div class="col-md-4 mt-5">
                        <div class="form-group">
                            <input type="button" value="{{trans('lang.submit')}}" id="submit-btn"
                                class="btn btn-primary">
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</section>

<div class="modal fade" id="product_cropper_modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div
                class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title">@lang('lang.crop_image_before_upload')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="" id="product_sample_image" />
                        </div>
                        <div class="col-md-4">
                            <div class="product_preview_div"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="product_crop" class="btn btn-primary col-md-6 px-0 m-0 rounded-0
                 text-center">@lang('lang.crop')</button>
                <button type="button" class="btn btn-default col-md-6 px-0 m-0 rounded-0 text-center"
                    data-dismiss="modal">@lang('lang.cancel')</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('js/product.js')}}"></script>
<script src="{{asset('js/raw_material.js')}}"></script>
<script type="text/javascript">

</script>
@endsection
