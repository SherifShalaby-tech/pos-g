<style type="text/css">
    .text-center {
        text-align: center;
    }

    .text-uppercase {
        text-transform: uppercase;
    }

    /*Css related to printing of barcode*/
    .label-border-outer {
        border: 0.1px solid grey !important;
    }

    .label-border-internal {
        /*border: 0.1px dotted grey !important;*/
    }

    .sticker-border {
        border: 0.1px dotted grey !important;
        overflow: hidden;
        box-sizing: border-box;
    }

    #preview_box {
        padding-left: 30px !important;
    }
    text {
        font-size: 8px !important;
    }
    @media print {
        .content-wrapper {
            border-left: none !important;
            /*fix border issue on invoice*/
        }

        .label-border-outer {
            border: none !important;
        }

        .label-border-internal {
            border: none !important;
        }

        .sticker-border {
            border: none !important;
        }

        #preview_box {
            padding-left: 0px !important;
        }

        #toast-container {
            display: none !important;
        }

        .tooltip {
            display: none !important;
        }

        .btn {
            display: none !important;
        }
    }

    @media print {
        #preview_body {
            display: block !important;
        }
    }

    @page {
        margin-top: 0in;
        margin-bottom: 0in;
        margin-left: 0in;
        margin-right: 0in;

    }
</style>

<title>{{ __('lang.print_labels') }}</title>
<button class="btn btn-success" onclick="window.print()">@lang('lang.print')</button>
<div id="preview_body">
    @php
        $loop_count = 0;
    @endphp
    @foreach ($product_details as $details)
        @while ($details['qty'] > 0)
            <div style="@if($page_height == 3) height:3cm !important; @else height:2.5cm !important; @endif width: 4cm;  display: inline-block;"
                class="sticker-border text-center">
                <div style=" padding: 3px 10px;;vertical-align:middle; @if($page_height == 3) font-size: 8px; @else font-size: 7px; @endif ">
                    @if (!empty($print['store']))
                        <p class="text-center" style="margin: 1px">
                            {{ $print['store'] }}
                        </p>
                    @endif
                    <p  style="margin: 0px; text-align: left;">
                        
                        @if (!empty($print['name']))
                            {{-- @if (!empty($print['size']) && !empty($details['details']->size_name))
                                {{ str_replace($details['details']->size_name, '', $details['details']->product_actual_name) }}
                            @elseif (!empty($print['color']) && !empty($details['details']->color_name))
                                {{ str_replace($details['details']->color_name, '', $details['details']->product_actual_name) }}
                            @else --}}
                                {{ $details['details']->product_actual_name }}
                            {{-- @endif --}}
                           
                        @endif
                    </p>
                    <div class="row" style="margin-top: 10px">
                        <p style="margin-top: -8px; text-align: left; font-weight: bold; margin-bottom: 0px;">
                        @if (!empty($print['color']) && !empty($details['details']->color_name))
                            {{ $details['details']->color_name }}
                        @endif
                        @if (!empty($print['color']) && !empty($details['details']->color_name) && !empty($print['size']) && !empty($details['details']->size_name))
                            -
                        @endif
                        @if (!empty($print['size']) && !empty($details['details']->size_name))
                            {{-- <p style="margin-top: -17px; text-align: right; font-weight: bold; margin-bottom: 0px;"> --}}
                                {{ $details['details']->size_name }}
                        @endif
                        </p>
                        {{-- Price --}}
                        @if (!empty($print['price']))
                            {{-- @lang('lang.price'): --}}
                            @php
                                $stockLines = \App\Models\AddStockLine::where('sell_price', '>', 0)
                                    ->where('variation_id', $details['details']->variation_id)
                                    ->latest()
                                    ->first();
                            @endphp
                            <p style="margin-top: -8px; text-align: right; font-weight: bold; margin-bottom: 0px;">
                                &nbsp;&nbsp;
                                {{ !empty($stockLines) ? @num_format($stockLines->sell_price) : @num_format($details['details']->default_sell_price) }}{{ $currency->symbol??''}}
                                
                            </p>
                        @endif
                    </div>
                    @php
                        $product = App\Models\Product::where('id', $details['details']->product_id)
                            ->with(['colors', 'sizes'])
                            ->first();
                    @endphp
                    <div style="@if($page_height == 3) font-size: 8px; @else font-size: 7px; @endif">
                        @if (!empty($print['size_variations']))
                            <p style="text-align: left; word-wrap: break-word; margin: 0%">
                                {{ implode(', ', $product->sizes->pluck('name')->toArray()) }}
                            </p>
                        @endif
                        @if (!empty($print['color_variations']))
                            <p style="text-align: left; word-wrap: break-word; padding-top: 3px; margin: 0%">

                                {{ implode(', ', $product->colors->pluck('name')->toArray()) }}
                            </p>
                        @endif
                    </div>
                    {{-- Grade --}}
                    <div style="" class="row d-flex justify-content-center">
                        @if (!empty($print['grade']) && !empty($details['details']->grade_name))
                            {{-- @lang('lang.grade'): --}}
                            <div style="text-align: left !important;" >
                            {{ $details['details']->grade_name }}</div>
                        @endif
                        @if (!empty($print['unit']) && !empty($details['details']->unit_name))
                            {{-- @lang('lang.unit'): --}}
                            <div style="text-align: right !important;  margin-top:-10;">{{ $details['details']->unit_name }}</div>
                        @endif
                        {{--  --}}
                        @if (!empty($print['free_text']))
                            <div  style="text-align: center !important; ">
                                {{ $print['free_text'] }}
                            </div>
                        @endif
                        {{--  --}}
                        {{-- Unit --}}
                       

                    </div>


                    {{-- <div class="center-block" >
                        {{$details['details']->sub_sku}}
                    </div> --}}
                    <div class="center-block" style="max-width: 95%; overflow: hidden; padding-left: 6px; vertical-align: top;">
                        {!! DNS1D::getBarcodeSVG($details['details']->sub_sku, "C128", 4,80, '#2A3239') !!}
                    </div>
                    @if (!empty($print['site_title']))
                            <p style="margin: 0%;">
                                {{ $print['site_title'] }}
                            </p>
                    @endif             
                    
                </div>
                {{-- <div class="row">
                    <div class="col-md-4" style="font-size: 8px; padding-left:6px">
                        @if (!empty($print['site_title']))
                            <p style="text-align: left; word-wrap: break-word;">
                                {{ $print['site_title'] }}
                            </p>
                        @endif
                       
                    </div>
                    {{-- @php
                        $product = App\Models\Product::where('id', $details['details']->product_id)
                            ->with(['colors', 'sizes'])
                            ->first();
                    @endphp --}}
                    {{-- <div class="col-md-4" style="font-size: 14px; margin-top: -30px;"></div> --}}
                    {{-- <div class="col-md-4" style="font-size: 14px; margin-top: -33px;padding-right:6px">
                        @if (!empty($print['size_variations']))
                            <p style="text-align: right; word-wrap: break-word;">
                                {{ implode(', ', $product->sizes->pluck('name')->toArray()) }}
                            </p>
                        @endif
                        @if (!empty($print['color_variations']))
                            <p style="text-align: right; word-wrap: break-word; padding-top: 3px;">

                                {{ implode(', ', $product->colors->pluck('name')->toArray()) }}
                            </p>
                        @endif
                    </div> --}}
                {{-- </div>  --}}
            </div>



            @php
                $details['qty'] = $details['qty'] - 1;
            @endphp
        @endwhile
    @endforeach

</div>


<script type="text/javascript"></script>
