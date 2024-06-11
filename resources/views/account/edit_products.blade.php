@extends('layouts.main')
@section('title', 'Edit Product')
@section('css')
    <style>
        .form-group {
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')

    <section class="rent-sec about-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="equipment">
                        <h1><span class="d-block">Edit Product</span></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="my-cart">
        <div class="my-account-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="myaccount-page-wrapper">
                            <div class="row">
                                @include('account.sidebar')
                                <div class="col-lg-9 col-md-8">
                                    <div class="tab-content" id="myaccountContent">
                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade show active" id="dashboad">
                                            <div class="myaccount-content">
                                                <div
                                                    class="section-heading d-flex justify-content-between align-items-center">
                                                    <h2>Edit Product</h2>
                                                </div>

                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                <form action="{{ route('update_product', ['id' => $product->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="form-group">
                                                        <label for="category">Select Category:</label>
                                                        <select name="item_id" id="category" class="form-control">
                                                            @foreach ($items as $item_id => $item_name)
                                                                <option value="{{ $item_id }}"
                                                                    {{ $product->category == $item_id ? 'selected' : '' }}>
                                                                    {{ $item_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="location">Select Location:</label>
                                                        <select name="location_id" id="location" class="form-control">
                                                            @foreach ($location as $location_id => $location_name)
                                                                <option value="{{ $location_id }}"
                                                                    {{ $product->location_id == $location_id ? 'selected' : '' }}>
                                                                    {{ $location_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="title">Product Title</label>
                                                        <input type="text" name="product_title" class="form-control"
                                                            id="title" value="{{ $product->product_title }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="price">Product Price</label>
                                                        <input type="number" step="any" name="price"
                                                            class="form-control" id="price"
                                                            value="{{ $product->price }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="delivery_charges">Delivery Charges</label>
                                                        <input type="number" step="any" name="delivery_charges"
                                                            id="delivery_charges" class="form-control"
                                                            value="{{ $product->delivery_charges }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="stock_inventory">Stock Inventory</label>
                                                        <input type="number" step="any" name="stock_inventory"
                                                            id="stock_inventory" class="form-control"
                                                            value="{{ $product->stock_inventory }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea name="description" id="summary-ckeditor" class="form-control" required>{{ $product->description }}</textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="image">Image</label>
                                                        <input class="form-control" name="image" type="file"
                                                            id="image">
                                                        <input type="hidden" id="old_image" name="old_image"
                                                            value="{{ $product->image }}">
                                                        @if ($product->image)
                                                            <img src="{{ asset($product->image) }}"
                                                                alt="{{ $product->product_title }}" width="100">
                                                        @endif
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="additional_image">Gallery Images</label>
                                                        <input type="file" class="form-control" name="images[]" multiple
                                                            id="additional_images">
                                                        <div id="existing-images">
                                                            @foreach ($product_images as $image)
                                                                <div class="image-container" data-id="{{ $image->id }}">
                                                                    <img src="{{ asset($image->image) }}"
                                                                        alt="{{ $product->product_title }}" width="100">
                                                                    <button type="button"
                                                                        class="remove-image btn-danger">&times;</button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    @foreach ($product->attributes as $pro_att_edits)
                                                        <div class="col-md-12">
                                                            <div data-repeater-list="attribute">
                                                                <div data-repeater-item="" class="row">
                                                                    <input type="hidden"
                                                                        value="{{ $pro_att_edits->id }}"
                                                                        name="product_attribute[]">
                                                                    <div class="form-group mb-1 col-sm-12 col-md-3">
                                                                        <label for="email-addr">Attribute</label>
                                                                        <br>
                                                                        <select class="form-control" id="attribute_id"
                                                                            name="attribute_id[]" onchange="getval(this)"
                                                                            disabled>
                                                                            <option
                                                                                value="{{ $pro_att_edits->attribute_id }}">
                                                                                {{ $pro_att_edits->attribute->name }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mb-1 col-sm-12 col-md-4">
                                                                        <label for="pass">value</label>
                                                                        <br>
                                                                        <select class="form-control value" id="value"
                                                                            name="value[]" disabled>
                                                                            <option value="{{ $pro_att_edits->value }}">
                                                                                {{ $pro_att_edits->attributesValues->value }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mb-1 col-sm-12 col-md-3">
                                                                        <label for="bio"
                                                                            class="cursor-pointer">Price</label>
                                                                        <br>
                                                                        <input type="number" name="v_price[]"
                                                                            class="form-control" id="price"
                                                                            value="{{ $pro_att_edits->price }}">
                                                                    </div>
                                                                    <!--<div class="form-group mb-1 col-sm-12 col-md-2">-->
                                                                    <!--    <label for="bio" class="cursor-pointer">qty</label>-->
                                                                    <!--    <br>-->
                                                                    <!--    <input type="number" name="qty[]" class="form-control" id="qty" value="{{ $pro_att_edits->qty }}">-->
                                                                    <!--</div>-->
                                                                    <div
                                                                        class="form-group col-sm-12 col-md-2 text-center mt-2">
                                                                        <button
                                                                            onclick="deleteAttr({{ $pro_att_edits->id }}, this)"
                                                                            type="button" class="btn btn-danger"
                                                                            data-repeater-delete=""> <i
                                                                                class="ft-x"></i>
                                                                            Delete</button>
                                                                    </div>

                                                                    <hr>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <div class="repeater-default col-md-12">
                                                        <div data-repeater-list="attribute">
                                                            <div data-repeater-item="" class="row">

                                                                <div class="form-group mb-1 col-sm-12 col-md-3">
                                                                    <label for="email-addr">Attribute</label>
                                                                    <br>
                                                                    <select class="form-control" id="attribute_id"
                                                                        name="attribute_id" onchange="getval(this)">
                                                                        @foreach ($att as $atts)
                                                                            <option value="{{ $atts->id }}">
                                                                                {{ $atts->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-1 col-sm-12 col-md-4">
                                                                    <label for="pass">value</label>
                                                                    <br>
                                                                    <select class="form-control value" id="value"
                                                                        name="value">

                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-1 col-sm-12 col-md-3">
                                                                    <label for="bio"
                                                                        class="cursor-pointer">Price</label>
                                                                    <br>
                                                                    <input type="number" name="v-price"
                                                                        class="form-control" id="price">
                                                                </div>
                                                                <!--<div class="form-group mb-1 col-sm-12 col-md-2">-->
                                                                <!--    <label for="bio" class="cursor-pointer">qty</label>-->
                                                                <!--    <br>-->
                                                                <!--    <input type="number" name="qty" class="form-control" id="qty" >-->
                                                                <!--</div>-->
                                                                <div
                                                                    class="form-group col-sm-12 col-md-2 text-center mt-2">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-repeater-delete=""> <i class="ft-x"></i>
                                                                        Delete</button>
                                                                </div>

                                                                <hr>
                                                            </div>
                                                        </div>
                                                        <div class="form-group overflow-hidden">
                                                            <div class="">
                                                                <button type="button" data-repeater-create=""
                                                                    class="btn btn-primary">
                                                                    <i class="ft-plus"></i> Add
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <button type="submit" class="btn btn-primary"
                                                        style="margin: 1px 0 0 0; float: right;">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                    </div>
                                </div> <!-- My Account Tab Content End -->
                            </div>
                        </div> <!-- My Account Page End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- my account wrapper end -->

        <!-- main content end -->
    </main>

@endsection

<style>
    #footer-form,
    #feedback-form,
    .navbar-brand {
        display: none;
    }
</style>

@section('js')
    <script src="https://www.jqueryscript.net/demo/repeatable-field-group/jquery.repeater.js"></script>
    <script>
        $(function() {
            // $('.dropify').dropify();
            $('.repeater-default').repeater()
        });

        if ($('#summary-ckeditor').length != 0) {
            CKEDITOR.replace('summary-ckeditor');
        }

        function getval(sel) {
            var globelsel = sel;
            let value = sel.value;

            // alert(value);

            $.ajax({
                url: "{{ route('get_attribute') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    value: value
                },
                success: function(response) {
                    $(globelsel).parent().parent().find('.value').html('');
                    if (response.status) {
                        var html = '';
                        for (var i = 0; i < response.message.length; i++) {
                            html += '<option value="' + response.message[i].id + '">' + response.message[i]
                                .value + '</option>';
                        }
                        $(globelsel).parent().parent().find('.value').html(html);
                    } else {

                    }
                },
            });
        }

        function deleteAttr(product_att_id, a) {
            var e = a;
            var id = product_att_id;
            $.ajax({
                url: "{{ route('delete_product_variant') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    if (response.status) {
                        $(e).parent().parent().parent().parent().remove();

                    } else {

                    }
                },
            });
        }
        // Handle remove image button click
        $(document).on('click', '.remove-image', function() {
            let imageContainer = $(this).closest('.image-container');
            let imageId = imageContainer.data('id');

            if (confirm('Are you sure you want to delete this image?')) {
                $.ajax({
                    url: '{{ route('delete_product_image') }}',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "image_id": imageId
                    },
                    success: function(response) {
                        if (response.status) {
                            imageContainer.remove();
                        } else {
                            alert('Failed to delete image.');
                        }
                    }
                });
            }
        });

        $('#additional_images').on('change', function() {
            var files = $(this)[0].files;
            var preview = $('#existing-images');

            preview.empty(); // Clear previous previews

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageContainer = $('<div class="image-container"></div>');
                    var img = $('<img>').attr('src', e.target.result).attr('width', 100);
                    var removeButton = $('<button type="button" class="remove-image">&times;</button>');

                    imageContainer.append(img).append(removeButton);
                    preview.append(imageContainer);
                }
                reader.readAsDataURL(files[i]);
            }
        });
    </script>
@endsection
