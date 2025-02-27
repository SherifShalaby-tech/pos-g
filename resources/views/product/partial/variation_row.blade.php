
<tr class="row_{{$row_id}} variation_row" data-row_id="{{$row_id}}">
    @if(!empty($item))
    {!! Form::hidden('variations['.$row_id.'][id]', !empty($item) ? $item->id : null, ['class' => 'form-control'])
    !!}
    @endif
    @php
    $product_name = null ;
    $product_sale_price = null ;
    $product_purchase_price = null ;
    $number_vs_base_unit = null ;
    if(!empty($item)){
    $product_name = $item->name;
    $product_sale_price = $item->sale_price;
    $product_purchase_price = $item->purchase_price;
    $number_vs_base_unit = $item->number_vs_base_unit;
    }else if(!empty($name)){
    $product_name = $name;
    $product_sale_price = $sell_price;
    $product_purchase_price = $purchase_price;
    }
    @endphp
    <td>
        {!! Form::hidden('name_hidden', $product_name,
        ['class' =>
        'form-control name_hidden'])
        !!}
        {!! Form::text('variations['.$row_id.'][name]', $product_name,
        ['class' =>
        'form-control v_name'])
        !!}</td>
    <td>{!! Form::text('variations['.$row_id.'][sub_sku]', !empty($item) ? $item->sub_sku : null, ['class' =>
        'form-control v_sub_sku']) !!}
    </td>
    <td>{!! Form::select('variations['.$row_id.'][color_id]', $colors, !empty($item) ? $item->color_id: false,
        ['class'
        => 'form-control selectpicker v_color', 'data-live-search'=>"true", 'placeholder' => ''])
        !!}
    </td>

    @if(isset($enable_tekstil) && !is_null($enable_tekstil) && $enable_tekstil->value == "true")
    <td>{!! Form::select('variations['.$row_id.'][multiple_thread_colors]', $colors, !empty($item) ? $item->color_id: false,
        ['class'
        => 'form-control selectpicker ', 'data-live-search'=>"true", 'placeholder' => '','style'=>"width:50%"])
        !!}
    </td>
    @endif
    <td>{!! Form::select('variations['.$row_id.'][size_id]', $sizes, !empty($item) ? $item->size_id: false, ['class'
        =>
        'form-control selectpicker v_size', 'data-live-search'=>"true", 'placeholder' => '']) !!}
    </td>
    <td>{!! Form::select('variations['.$row_id.'][grade_id]', $grades, !empty($item) ? $item->grade_id: false,
        ['class'
        => 'form-control selectpicker v_grade', 'data-live-search'=>"true", 'placeholder' => ''])
        !!}
    </td>
    <td>{!! Form::select('variations['.$row_id.'][unit_id]', $units, !empty($item) ? $item->unit_id: false, ['class'
        =>
        'form-control selectpicker v_unit', 'data-live-search'=>"true", 'placeholder' => '','onchange'=>"get_unit($units_js,$row_id)" , 'id'=>'select_unit_id_'.$row_id]) !!}
    </td>
        @if(session('system_mode') != 'garments')
            <td>{!! Form::number('variations['.$row_id.'][number_vs_base_unit]', $number_vs_base_unit , ['class' =>
                'form-control
                number_vs_base_unit','id'=>'number_vs_base_unit_'.$row_id]) !!}</td>
        @endif
        {{-- @if(empty($is_service)) hide @endif --}}

    <td class="supplier_div default_purchase_price_td @if(isset($is_service) && $is_service!=1) hide @endif">{!! Form::text('variations['.$row_id.'][default_purchase_price]', $product_purchase_price , ['class' =>

        'form-control
        default_purchase_price']) !!}</td>


    <td class="supplier_div default_sell_price_td @if(isset($is_service) && $is_service!=1) hide @endif ">{!! Form::text('variations['.$row_id.'][default_sell_price]', $product_sale_price,

        ['class' => 'form-control default_sell_price']) !!}</td>
    <td> <button type="button" class="btn btn-danger btn-xs remove_row mt-2"><i class="dripicons-cross"></i></button>
    </td>
</tr>
<tr class="variant_store_checkbox_{{$row_id}}">
    <td colspan="9">
        <input name="variant_different_prices_for_stores" type="checkbox" @if(!empty($item) && $item->name !=
        'Default') checked @endif value="1" data-row_id="{{$row_id}}"
        class="variant_different_prices_for_stores"><strong>@lang('lang.variant_different_prices_for_stores')</strong>
    </td>
</tr>

@foreach ($stores as $store)
<tr class="variant_store_prices_{{$row_id}}">
    <td>
        {{$store->name}}
    </td>
    @php
    $variant_store = null;
    if(!empty($item)){
    $variant_store = $item->product_stores->where('store_id', $store->id)->first();
    }
    @endphp
    <td colspan="4">
        @if(!empty($variant_store ))
        <input type="hidden" class="form-control" name="variations[{{$row_id}}][variant_stores][{{$store->id}}][id]"
            value="{{$variant_store->id}}">
        @endif

        <input type="hidden" class="form-control"
            name="variations[{{$row_id}}][variant_stores][{{$store->id}}][store_id]" value="{{$store->id}}">
        <input type="text" class="form-control store_prices" style="width: 200px;"
            name="variations[{{$row_id}}][variant_stores][{{$store->id}}][price]"
            value="@if(!empty($variant_store)){{$variant_store->price}}@endif">

    </td>
</tr>
@endforeach
