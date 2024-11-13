@extends('layouts.app')
@section('title', __('lang.expense_beneficiary'))

@section('content')
<section class="forms pt-2">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">


                <x-page-title>
                    <h4>@lang('lang.add_expense_beneficiary')</h4>

                </x-page-title>


                {!! Form::open(['url' => action('ExpenseBeneficiaryController@store'), 'method' =>
                'post'])
                !!}

                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="locale_label mb-1"
                                        for="expense_category_id">@lang('lang.expense_category')</label>
                                    {!! Form::select('expense_category_id', $expense_categories, null, ['class'
                                    =>
                                    'form-control', 'required', 'placeholder' => __('lang.please_select')]) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="locale_label mb-1" for="name">@lang('lang.beneficiary_name')</label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-1 mb-0">
                    <div class="card-body py-2 px-4">
                        <div class="row locale_dir">

                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-primary" value="@lang('lang.save')" name="submit">
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
<script>

</script>
@endsection
