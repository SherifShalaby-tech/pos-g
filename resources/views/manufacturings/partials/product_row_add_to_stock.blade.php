@forelse ($products as $product)
@php
$i = $index;
@endphp

    <tr class="product_row">
        <td><img src="@if(!empty($product->getFirstMediaUrl('product'))){{$product->getFirstMediaUrl('product')}}@else{{asset('/uploads/'.session('logo'))}}@endif"
                 alt="photo" width="50" height="50"></td>
        <td>
            @if($product->variation_name != "Default")
                <b>{{$product->variation_name}} {{$product->sub_sku}}</b>
            @else
                {{$product->product_name}}
            @endif
        </td>
        <td>
            <input type="hidden" id="product_id" name="product_id[]" value="{{ $product->id }}">
            <input type="text" class="form-control quantity product_{{$product->id}}" id="input_product_{{$product->id}}" name="product_quentity[{{$product->id}}][{{ $product->variation_id }}][quantity]" required
                   value="@if(isset($product->quantity)){{preg_match('/\.\d*[1-9]+/', (string)$product->quantity) ? $product->quantity : @num_format($product->quantity)}}@else{{1}}@endif"  index_id="{{$i}}">
        </td>
        <td>
            {{$product->units->pluck('name')[0]??''}}
        </td>
        <td>
            <input type="number" class="purchase_unit" name="product_quentity[{{$product->id}}][{{ $product->variation_id }}][purchase_unit]" value="">
        </td>
        <td>
            <input type="number" class="sell_unit" name="product_quentity[{{$product->id}}][{{ $product->variation_id }}][sell_unit]" value="{{ @num_format(0) }}">
        </td>
        <td>
            <input type="checkbox" class="change_current_stock" name="product_quentity[{{$product->id}}][{{ $product->variation_id }}][change_current_stock]" >
        </td>
        <td>
            <button style="margin-top: 33px;" type="button" class="btn btn-danger btn-sx remove_product_row" data-index="{{$i}}"><i
                    class="fa fa-times"></i></button>
        </td>
    </tr>
@empty

@endforelse
<script>
    $('.datepicker').datepicker({
        language: "{{session('language')}}",
    })
</script>
