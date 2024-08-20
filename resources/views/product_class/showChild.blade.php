<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <h4 class="modal-title">@lang( 'lang.classDetails' )</h4>
            <button type="button"
                class="btn text-primary rounded-circle d-flex justify-content-center align-items-center modal-close-btn"
                data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Tree</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @foreach($product_class->categories as $main_category)
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="{{$main_category->id}}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse"
                                                    data-target="#{{$main_category->name}}" aria-expanded="false"
                                                    aria-controls="collapseTwo">
                                                    {{$main_category->name??"No Data"}}
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="{{$main_category->name}}" class="collapse"
                                            aria-labelledby="{{$main_category->id}}" data-parent="#accordion">
                                            <div class="card-body">
                                                @foreach($main_category->subcategories as $subCategory)
                                                <p>{{$subCategory->name??"No Data"}}</p>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default col-md-12 px-0 m-0 rounded-0 text-center"
                    data-dismiss="modal">@lang('lang.close')</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>
