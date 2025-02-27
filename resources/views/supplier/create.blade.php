@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
    <style>
        .preview-container {
            /* display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px; */
            display: grid;
            grid-template-columns: repeat(auto-fill, 170px);
        }

        .preview {
            position: relative;
            width: 150px;
            height: 150px;
            padding: 4px;
            box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            margin: 30px 0px;
            border: 1px solid #ddd;
        }

        .preview img {
            width: 100%;
            height: 100%;
            box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            border: 1px solid #ddd;
            object-fit: cover;

        }

        .delete-btn {
            position: absolute;
            top: 156px;
            right: 0px;
            /*border: 2px solid #ddd;*/
            border: none;
            cursor: pointer;
        }

        .delete-btn {
            background: transparent;
            color: rgba(235, 32, 38, 0.97);
        }

        .crop-btn {
            position: absolute;
            top: 156px;
            left: 0px;
            /*border: 2px solid #ddd;*/
            border: none;
            cursor: pointer;
            background: transparent;
            color: #007bff;
        }
    </style>

    <style>
        .variants {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .variants>div {
            margin-right: 5px;
        }

        .variants>div:last-of-type {
            margin-right: 0;
        }

        .file {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .file>input[type='file'] {
            display: none
        }

        .file>label {
            font-size: 1rem;
            font-weight: 300;
            cursor: pointer;
            outline: 0;
            user-select: none;
            border-color: rgb(216, 216, 216) rgb(209, 209, 209) rgb(186, 186, 186);
            border-style: solid;
            border-radius: 4px;
            border-width: 1px;
            background-color: hsl(0, 0%, 100%);
            color: hsl(0, 0%, 29%);
            padding-left: 16px;
            padding-right: 16px;
            padding-top: 16px;
            padding-bottom: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .file>label:hover {
            border-color: hsl(0, 0%, 21%);
        }

        .file>label:active {
            background-color: hsl(0, 0%, 96%);
        }

        .file>label>i {
            padding-right: 5px;
        }

        .file--upload>label {
            color: hsl(204, 86%, 53%);
            border-color: hsl(204, 86%, 53%);
        }

        .file--upload>label:hover {
            border-color: hsl(204, 86%, 53%);
            background-color: hsl(204, 86%, 96%);
        }

        .file--upload>label:active {
            background-color: hsl(204, 86%, 91%);
        }

        .file--uploading>label {
            color: hsl(48, 100%, 67%);
            border-color: hsl(48, 100%, 67%);
        }

        .file--uploading>label>i {
            animation: pulse 5s infinite;
        }

        .file--uploading>label:hover {
            border-color: hsl(48, 100%, 67%);
            background-color: hsl(48, 100%, 96%);
        }

        .file--uploading>label:active {
            background-color: hsl(48, 100%, 91%);
        }

        .file--success>label {
            color: hsl(141, 71%, 48%);
            border-color: hsl(141, 71%, 48%);
        }

        .file--success>label:hover {
            border-color: hsl(141, 71%, 48%);
            background-color: hsl(141, 71%, 96%);
        }

        .file--success>label:active {
            background-color: hsl(141, 71%, 91%);
        }

        .file--danger>label {
            color: hsl(348, 100%, 61%);
            border-color: hsl(348, 100%, 61%);
        }

        .file--danger>label:hover {
            border-color: hsl(348, 100%, 61%);
            background-color: hsl(348, 100%, 96%);
        }

        .file--danger>label:active {
            background-color: hsl(348, 100%, 91%);
        }

        .file--disabled {
            cursor: not-allowed;
        }

        .file--disabled>label {
            border-color: #e6e7ef;
            color: #e6e7ef;
            pointer-events: none;
        }

        @keyframes pulse {
            0% {
                color: hsl(48, 100%, 67%);
            }

            50% {
                color: hsl(48, 100%, 38%);
            }

            100% {
                color: hsl(48, 100%, 67%);
            }
        }
    </style>
@endsection
@section('title', __('lang.supplier'))
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>@lang('lang.add_supplier')</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic"><small>@lang('lang.required_fields_info')</small></p>
                            {!! Form::open(['url' => action('SupplierController@store'), 'id' => 'supplier-form', 'method' => 'POST', 'class' => '', 'enctype' => 'multipart/form-data']) !!}

                            @include('supplier.partial.create_supplier_form')

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="button" value="{{ trans('lang.submit') }}" id="submit-btn"
                                            class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <script>
        const fileInput = document.querySelector('#file-input');
        const previewContainer = document.querySelector('.preview-container');
        const croppieModal = document.querySelector('#croppie-modal');
        const croppieContainer = document.querySelector('#croppie-container');
        const croppieCancelBtn = document.querySelector('#croppie-cancel-btn');
        const croppieSubmitBtn = document.querySelector('#croppie-submit-btn');

        // let currentFiles = [];
        fileInput.addEventListener('change', () => {
            previewContainer.innerHTML = '';
            let files = Array.from(fileInput.files)
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        const preview = document.createElement('div');
                        preview.classList.add('preview');
                        const img = document.createElement('img');
                        const actions = document.createElement('div');
                        actions.classList.add('action_div');
                        img.src = reader.result;
                        preview.appendChild(img);
                        preview.appendChild(actions);

                        const container = document.createElement('div');
                        const deleteBtn = document.createElement('button');
                        deleteBtn.classList.add('delete-btn');
                        deleteBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-trash"></i>';
                        deleteBtn.addEventListener('click', () => {
                            if (window.confirm('Are you sure you want to delete this image?')) {
                                files.splice(file, 1)
                                preview.remove();
                                getImages()
                            }
                        });

                        preview.appendChild(deleteBtn);
                        const cropBtn = document.createElement('button');
                        cropBtn.setAttribute("data-toggle", "modal")
                        cropBtn.setAttribute("data-target", "#exampleModal")
                        cropBtn.classList.add('crop-btn');
                        cropBtn.innerHTML = '<i style="font-size: 20px;" class="fas fa-crop"></i>';
                        cropBtn.addEventListener('click', () => {
                            setTimeout(() => {
                                launchCropTool(img);
                            }, 500);
                        });
                        preview.appendChild(cropBtn);
                        previewContainer.appendChild(preview);
                    });
                    reader.readAsDataURL(file);
                }
            }

            getImages()
        });
        function launchCropTool(img) {
            // Set up Croppie options
            const croppieOptions = {
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'square' // or 'square'
                },
                boundary: {
                    width: 300,
                    height: 300,
                },
                enableOrientation: true
            };

            // Create a new Croppie instance with the selected image and options
            const croppie = new Croppie(croppieContainer, croppieOptions);
            croppie.bind({
                url: img.src,
                orientation: 1,
            });

            // Show the Croppie modal
            croppieModal.style.display = 'block';

            // When the user clicks the "Cancel" button, hide the modal
            croppieCancelBtn.addEventListener('click', () => {
                croppieModal.style.display = 'none';
                $('#exampleModal').modal('hide');
                croppie.destroy();
            });

            // When the user clicks the "Crop" button, get the cropped image and replace the original image in the preview
            croppieSubmitBtn.addEventListener('click', () => {
                croppie.result('base64').then((croppedImg) => {
                    img.src = croppedImg;
                    croppieModal.style.display = 'none';
                    $('#exampleModal').modal('hide');
                    croppie.destroy();
                    getImages()

                    // blob = new Blob(croppedImg, { type: 'image/*' });
                    let blob = new Blob([croppedImg], {
                        type: "image/png"
                    });
                });
            });
        }

        function getImages() {
            setTimeout(() => {
                const container = document.querySelectorAll('.preview-container');
                let images = [];
                $("#cropped_images").empty();
                for (let i = 0; i < container[0].children.length; i++) {
                    images.push(container[0].children[i].children[0].src)
                    var newInput = $("<input>").attr("type", "hidden").attr("name", "cropImages[]").val(container[0].children[i].children[0].src);
                    $("#cropped_images").append(newInput);
                }
                console.log(images);
                return images
            }, 500);
        }

    </script>


    <script type="text/javascript">
        $('#supplier-type-form').submit(function() {
            $(this).validate();
            if ($(this).valid()) {
                $(this).submit();
            }
        });

        $(document).on("click", "#submit-btn", function(e) {
            e.preventDefault();
            if ($('#supplier-form').valid()) {
                $('#supplier-form').submit();
            }
        });
        $(document).on("submit", "form#quick_add_supplier_category_form", function(e) {
            $("form#quick_add_supplier_category_form").validate();
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                method: "post",
                url: $(this).attr("action"),
                dataType: "json",
                data: data,
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result.success) {
                        swal("Success", result.msg, "success");
                        $(".view_modal").modal("hide");
                        var supplier_category_id = result.supplier_category_id;
                        $.ajax({
                            method: "get",
                            url: "/supplier-category/get-dropdown",
                            data: {},
                            contactType: "html",
                            success: function(result) {
                                $("select#supplier_category_id").html(result);
                                $("select#supplier_category_id").val(supplier_category_id);
                                $("#supplier_category_id").selectpicker("refresh");

                            },
                        });
                    } else {
                        swal("Error", result.msg, "error");
                    }
                },
            });
        });
    </script>
@endsection
