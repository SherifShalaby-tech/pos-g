@extends('layouts.app')
@section('title', __('lang.color'))

@section('content')
<div class="container-fluid">

    <div class="col-md-12  no-print">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="print-title">@lang('lang.colors')</h4>
            </div>
            <div class="card-header d-flex align-items-center">
                @can('product_module.color.create_and_edit')
                <a style="color: white" data-href="{{action('ColorController@create')}}"
                    data-container=".view_modal" class="btn btn-modal btn-info"><i class="dripicons-plus"></i>
                    @lang('lang.add_color')</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="store_table" class="table dataTable">
                        <thead>
                            <tr>
                                <th>@lang('lang.name')</th>
                                <th>@lang('lang.color_hex')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($colors as $color)
                            <tr>
                                <td>{{$color->name}}</td>
                                <td>{{$color->color_hex}}</td>

                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">@lang('lang.action')
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                            user="menu">
                                            @can('product_module.color.create_and_edit')
                                            <li>

                                                <a data-href="{{action('ColorController@edit', $color->id)}}"
                                                    data-container=".view_modal" class="btn btn-modal"><i
                                                        class="dripicons-document-edit"></i> @lang('lang.edit')</a>
                                            </li>
                                            <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{action('ColorController@getColorProducts', $color->id)}}"
                                                       data-container=".view_modal" class="btn btn-modal"><i
                                                            class="dripicons-document-edit"></i> @lang('lang.products')</a>
                                                </li>
                                            @endcan
                                            @can('product_module.color.delete')
                                            <li>
                                                <a data-href="{{action('ColorController@destroy', $color->id)}}"
                                                    data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}"
                                                    class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                    @lang('lang.delete')</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')

@endsection
