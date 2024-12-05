@extends('layouts.app')
@section('title', __('lang.employee'))

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">

            <x-page-title>

                <h4>@lang('lang.edit_employee')</h4>
            </x-page-title>

            {!! Form::open(['url' => action('EmployeeController@update', $employee->id), 'method' => 'put', 'id'
            => 'edit_employee_form', 'enctype' => 'multipart/form-data']) !!}

            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="row">

                        <div class="col-sm-6">
                            <label for="fname">@lang('lang.name'):*</label>
                            <input type="text" class="form-control" name="name" value="{{ $employee->name }}"
                                @if($employee->name == 'Admin') readonly @endif
                            id="name" required placeholder="Name">
                        </div>
                        <div class="col-sm-6">
                            <label for="store_id">@lang('lang.store')</label>
                            {!! Form::select('store_id[]', $stores, !empty($employee->store_id) ? $employee->store_id :
                            [], ['class' => 'form-control selectpicker', 'multiple', 'placeholder' =>
                            __('lang.please_select'), 'data-live-search' => 'true', 'id' => 'store_id']) !!}
                        </div>
                        <div class="col-sm-6">
                            <label
                                for="email">@lang('lang.email'):*<small>(@lang('lang.it_will_be_used_for_login'))</small></label>
                            <input type="email" class="form-control" name="email" value="{{ $employee->email }}"
                                id="email" required placeholder="Email">
                        </div>

                    </div>

                    <div class="row mt-4">

                        <div class="col-sm-6">
                            <label for="password">@lang('lang.password')</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Create New Password">
                        </div>
                        <div class="col-sm-5">
                            <label for="pass">@lang('lang.confirm_password')</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Conform Password">
                        </div>
                        <div class="col-sm-1 pt-4">
                            <a class="btn-primary btn print-employee-barcode text-white"
                                data-href="{{ route('print_employee_barcode', $employee->id) }}"><i
                                    class="dripicons-print"></i></a>
                        </div>
                    </div>
                    <div class="row mt-4">

                        <div class="col-sm-6">
                            <label for="date_of_start_working">@lang('lang.date_of_start_working')</label>
                            <input type="date_of_start_working" class="form-control" name="date_of_start_working"
                                value="@if (!empty($employee->date_of_start_working)) {{ @format_date($employee->date_of_start_working) }} @endif"
                                id="date_of_start_working" placeholder="@lang('lang.date_of_start_working')">
                        </div>
                        <div class="col-sm-6">
                            <label for="date_of_birth">@lang('lang.date_of_birth')</label>
                            <input type="date_of_birth" class="form-control" name="date_of_birth" id="date_of_birth"
                                value="@if (!empty($employee->date_of_birth)) {{ @format_date($employee->date_of_birth) }} @endif"
                                placeholder="@lang('lang.date_of_birth')">
                        </div>

                    </div>
                    <div class="row mt-4">

                        <div class="col-sm-6">
                            <label for="job_type">@lang('lang.job_type')</label>
                            {!! Form::select('job_type_id', $jobs, $employee->job_type_id, ['class' => 'form-control',
                            'placeholder' => __('lang.select_job_type')]) !!}
                        </div>
                        <div class="col-sm-6">
                            <label for="mobile">@lang('lang.mobile'):*</label>
                            <input type="mobile" class="form-control" name="mobile" id="mobile" required
                                value="{{ $employee->mobile }}" placeholder="@lang('lang.mobile')">
                        </div>

                    </div>
                    <div class="row mt-4">

                        <div class="col-sm-6">
                            <label for="upload_files">@lang('lang.upload_files')</label>
                            {!! Form::file('upload_files[]', ['class' => 'form-control', 'multiple']) !!}
                        </div>
                        <div class="col-md-6">
                            <label for="photo">@lang('lang.profile_photo')</label>
                            <input type="file" name="photo" id="photo" class="form-control" />
                        </div>
                    </div>

                    <div class="row mt-4">
                        @foreach ($number_of_leaves as $number_of_leave)
                        <div class="col-sm-6">
                            <div class="i-checks">
                                <input @if ($number_of_leave->enabled == 1) checked @endif id="number_of_leaves{{
                                $number_of_leave->id }}"
                                name="number_of_leaves[{{ $number_of_leave->id }}][enabled]" type="checkbox" value="1"
                                class="form-control-custom">
                                <label for="number_of_leaves{{ $number_of_leave->id }}"><strong>{{
                                        $number_of_leave->name }}</strong></label>
                                <input type="number" class="form-control"
                                    name="number_of_leaves[{{ $number_of_leave->id }}][number_of_days]"
                                    id="number_of_leaves" readonly placeholder="{{ $number_of_leave->name }}"
                                    value="{{ $number_of_leave->number_of_days }}">
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row mt-4">
                        <!-- Button trigger modal -->
                        <button type="button" style="margin-left: 15px;" class="btn btn-primary" data-toggle="modal"
                            data-target="#salary_details">
                            @lang('lang.salary_details')
                        </button>

                        @include('employee.partial.salary_details')
                    </div>
                </div>
            </div>

            <x-collapse-button color="primary my-1 d-flex product-btn justify-content-end"
                collapse-id="select_working_day_per_week">
                @lang('lang.select_working_day_per_week')
            </x-collapse-button>

            <x-collapse-body collapse-id="select_working_day_per_week">


                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>@lang('lang.check_in')</th>
                            <th> @lang('lang.check_out')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($week_days as $key => $week_day)
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="i-checks">
                                        <input @if (!empty($employee->working_day_per_week[$key])) checked
                                        @endif id="working_day_per_week{{ $key }}"
                                        name="working_day_per_week[{{ $key }}]"
                                        type="checkbox" value="1" class="form-control-custom">
                                        <label for="working_day_per_week{{ $key }}"><strong>{{ $week_day
                                                }}</strong></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {!! Form::text('check_in[' . $key . ']', !empty($employee->check_in[$key]) ?
                                $employee->check_in[$key] : null, ['class' => 'form-control input-md
                                check_in time_picker ']) !!}
                            </td>
                            <td>
                                {!! Form::text('check_out[' . $key . ']', !empty($employee->check_out[$key])
                                ? $employee->check_out[$key] : null, [
                                'class' => 'form-control input-md check_out
                                time_picker',
                                ]) !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-collapse-body>

            <x-collapse-button color="primary my-1 d-flex product-btn justify-content-end" collapse-id="user_rights">
                @lang('lang.user_rights')
            </x-collapse-button>

            <x-collapse-body collapse-id="user_rights">


                <div class="col-md-12">
                    @include('employee.partial.permission')
                </div>
            </x-collapse-body>

            <div class="card mt-1 mb-0">
                <div class="card-body py-2 px-4">
                    <div class="row">

                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary"
                                id="submit-btn">@lang('lang.update_employee')</button>
                        </div>

                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>



@endsection

@section('javascript')
<script>
    $('#date_of_start_working').datepicker({
            language: '{{ session('language') }}',
            todayHighlight: true,
        });
        $('#date_of_birth').datepicker({
            language: '{{ session('language') }}',
        });


        $('#fixed_wage').change(function() {
            console.log($(this).prop('checked'));
        })

        $('.checked_all').change(function() {
            tr = $(this).closest('tr');
            var checked_all = $(this).prop('checked');
            console.log(checked_all);

            tr.find('.check_box').each(function(item) {
                if (checked_all === true) {
                    $(this).prop('checked', true)
                } else {
                    $(this).prop('checked', false)
                }
            })
        })
        $('.all_module_check_all').change(function() {
            var all_module_check_all = $(this).prop('checked');
            $('#permission_table > tbody > tr').each((i, tr) => {
                $(tr).find('.check_box').each(function(item) {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })
                $(tr).find('.module_check_all').each(function(item) {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })
                $(tr).find('.checked_all').each(function(item) {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })

            })
        })
        $('.module_check_all').change(function() {
            let moudle_id = $(this).closest('tr').data('moudle');
            if ($(this).prop('checked')) {
                $('.sub_module_permission_' + moudle_id).find('.checked_all').prop('checked', true);
                $('.sub_module_permission_' + moudle_id).find('.check_box').prop('checked', true);
            } else {
                $('.sub_module_permission_' + moudle_id).find('.checked_all').prop('checked', false);
                $('.sub_module_permission_' + moudle_id).find('.check_box').prop('checked', false);
            }
        });
        $(document).on('change', '.view_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_view').prop('checked', true);
            } else {
                $('.check_box_view').prop('checked', false);
            }
        });
        $(document).on('change', '.create_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_create').prop('checked', true);
            } else {
                $('.check_box_create').prop('checked', false);
            }
        });
        $(document).on('change', '.delete_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_delete').prop('checked', true);
            } else {
                $('.check_box_delete').prop('checked', false);
            }
        });

        $(document).on('click', '#submit-btn', function(e) {
            jQuery('#edit_employee_form').validate({
                rules: {
                    password: {
                        minlength: function() {
                            return $('#password').val().length > 0 ? 6 : 0;
                        }
                    },
                    password_confirmation: {
                        minlength: function() {
                            return $('#password').val().length > 0 ? 6 : 0;
                        },
                        equalTo: {
                            depends: function() {
                                return $('#password').val().length > 0;
                            },
                            param: "#password"
                        }
                    }
                }
            });
            if ($('#edit_employee_form').valid()) {
                $('form#edit_employee_form').submit();
            }
        })
        $(document).on('focusout', '.check_in', function() {
            $('.check_in').val($(this).val())
        })
        $(document).on('focusout', '.check_out', function() {
            $('.check_out').val($(this).val())
        })
        $(document).on('click', '.salary_cancel', function() {
            $('.salary_fields').val('');
            $('.salary_select').val('');
            $('.salary_select').selectpicker('refresh');
            $('.salary_checkbox').prop('checked', false);

        })
        $(document).on('click', '.print-employee-barcode', function(e) {
            e.preventDefault();
            var url = $(this).data('href');

            Swal.fire({
                title: "{!! __('lang.please_enter_your_password') !!}",
                input: 'password',
                inputAttributes: {
                    placeholder: "{!! __('lang.type_your_password') !!}",
                    autocomplete: 'off',
                    autofocus: true,
                },
            }).then((result) => {
                if (result) {
                    $.ajax({
                        type: "get",
                        url: url,
                        data: {
                            value: result,
                        },
                        success: function(response) {
                            var newWindow = window.open();
                            newWindow.document.write(response);
                            Swal.fire(
                                'success',
                                "{!! __('lang.correct_password') !!}",
                                'success'
                            );
                        }
                    });
                } else {
                    Swal.fire(
                        'Failed!',
                        'Wrong Password!',
                        'error'
                    )

                }
            });
        });
</script>
@endsection
