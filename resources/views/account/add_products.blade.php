@extends('layouts.main')
@section('title', 'Add Product')
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
                    <h1><span class="d-block">Add Product</span></h1>
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
                                            <div class="section-heading d-flex justify-content-between align-items-center">
                                                <h2>Add Product</h2>
                                            </div>
                                            
                                            @if($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <form action="{{ route('store_product') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="category">Select Category:</label>
                                                    <select name="item_id" id="category" class="form-control">
                                                        @foreach($items as $item_id => $item_name)
                                                            <option value="{{ $item_id }}" {{ isset($product) && $product->category == $item_id ? 'selected' : '' }}>
                                                                {{ $item_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                                <div class="form-group">
                                                    <label for="location">Select Location:</label>
                                                    <select name="location_id" id="location" class="form-control">
                                                        @foreach($location as $location_id => $location_name)
                                                            <option value="{{ $location_id }}" {{ isset($product) && $product->location_id == $location_id ? 'selected' : '' }}>
                                                                {{ $location_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                                                               
                                                <div class="form-group">
                                                    <label for="title">Product Title</label>
                                                    <input type="text" name="product_title" class="form-control" id="title" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="price">Product Price</label>
                                                    <input type="number" step="any" name="price" class="form-control" id="price" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="delivery_charges">Delivery Charges</label>
                                                    <input type="number" step="any" name="delivery_charges" id="delivery_charges" class="form-control" {{ 'required' == 'required' ? 'required' : '' }} value="{{ isset($product) ? $product->delivery_charges : '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="stock_inventory">Stock Inventory</label>
                                                    <input type="number" step="any" name="stock_inventory" id="stock_inventory" class="form-control" {{ 'required' == 'required' ? 'required' : '' }} value="{{ isset($product) ? $product->stock_inventory : '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="summary-ckeditor" class="form-control" {{ 'required' == 'required' ? 'required' : '' }}>{{ isset($product) ? $product->description : '' }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">Image</label>
                                                    <input class="form-control" name="image" type="file" id="image">
                                                </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="additional_image">Gallery Image</label>
                                                    <input type="file" class="form-control" name="images[]" placeholder="address" multiple>
                                                    {{-- <input class="form-control dropify" name="images[]" type="file" id="images" multiple> --}}
                                                </div>

                                                <div class="repeater-default col-md-12">
                                                    <div data-repeater-list="attribute">
                                                        <div data-repeater-item="" class="row">
                                        
                                                                <div class="form-group mb-1 col-sm-12 col-md-3">
                                                                    <label for="email-addr">Attribute</label>
                                                                    <br>
                                                                    <select class="form-control" id="attribute_id" name="attribute_id" onchange="getval(this)">
                                                                        @foreach($att as $atts)
                                                                        <option value="{{ $atts->id}}">{{ $atts->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-1 col-sm-12 col-md-4">
                                                                    <label for="pass">value</label>
                                                                    <br>
                                                                     <select class="form-control value" id="value" name="value">
                                        
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-1 col-sm-12 col-md-3">
                                                                    <label for="bio" class="cursor-pointer">Price</label>
                                                                    <br>
                                                                    <input type="number" name="v-price" class="form-control" id="price" >
                                                                </div>
                                                                <!--<div class="form-group mb-1 col-sm-12 col-md-2">-->
                                                                <!--    <label for="bio" class="cursor-pointer">qty</label>-->
                                                                <!--    <br>-->
                                                                <!--    <input type="number" name="qty" class="form-control" id="qty" >-->
                                                                <!--</div>-->
                                                                <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                                                    <button type="button" class="btn btn-danger" data-repeater-delete=""> <i class="ft-x"></i>
                                                                        Delete</button>
                                                                </div>
                                        
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <div class="form-group overflow-hidden">
                                                        <div class="">
                                                            <button type="button" data-repeater-create="" class="btn btn-primary">
                                                                <i class="ft-plus"></i> Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- <div class="repeater-default col-md-12">
                                                    <div data-repeater-list="attribute">
                                                        <div data-repeater-item="" class="row">
                                        
                                                                <div class="form-group mb-1 col-sm-12 col-md-3">
                                                                    <label for="email-addr">Attribute</label>
                                                                    <br>
                                                                    <select class="form-control" id="attribute_id" name="attribute_id" onchange="getval(this)" required>
                                                                        @foreach($att as $atts)
                                                                        <option value="{{ $atts->id}}">{{ $atts->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-1 col-sm-12 col-md-4">
                                                                    <label for="pass">value</label>
                                                                    <br>
                                                                        <select class="form-control value" id="value" name="value" required>
                                        
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-1 col-sm-12 col-md-3">
                                                                    <label for="bio" class="cursor-pointer">Price</label>
                                                                    <br>
                                                                    <input type="number" name="v-price" class="form-control" id="price" required>
                                                                </div>
                                                                <div class="form-group col-sm-12 col-md-2 text-center mt-4">
                                                                    <button type="button" class="btn btn-danger" data-repeater-delete=""> <i class="fa-solid fa-xmark"></i></button>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group overflow-hidden">
                                                        <div class="">
                                                            <button type="button" data-repeater-create="" class="btn btn-primary">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                
                                                
                                                <button type="submit" class="btn btn-primary" style="margin: 1px 0 0 0; float: right;">Create</button>
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
    #footer-form,#feedback-form,.navbar-brand {
        display: none;
    }
</style>

@section('js')
<script src="{{asset('js/jquery.repeater.min.js')}}"></script>
<script>
    if($('#summary-ckeditor').length != 0){
        CKEDITOR.replace( 'summary-ckeditor' );
    }
    if($('#summary-ckeditor1').length != 0){
        CKEDITOR.replace( 'summary-ckeditor1' );
    }
    if($('#summary-ckeditor2').length != 0){
        CKEDITOR.replace( 'summary-ckeditor2' );
    }

    $(document).ready(function() {
        $(".repeater-default").repeater();
        $(".file-repeater, .contact-repeater").repeater({
            show: function() {
                $(this).slideDown();
            },
            hide: function(e) {
                if (confirm("Are you sure you want to remove this item?")) {
                    $(this).slideUp(e);
                }
            }
        });

        // Hide the close button for the first item
        $('.repeater-default [data-repeater-item]:first-of-type .btn-danger').hide();
    });

    function getval(sel)
    {
        var globelsel = sel;
        let value = sel.value;

        // alert(value);
        
        $.ajax({
        url: "{{ route('get_attribute')}}",
            type:"POST",
            data:{
                "_token": "{{ csrf_token() }}",
                value:value
            },
            success:function(response){
                $(globelsel).parent().parent().find('.value').html('');
                if(response.status){
                    var html = '';
                    for(var i = 0; i < response.message.length; i++){
                        html += '<option value="'+response.message[i].id+'">'+response.message[i].value+'</option>';
                    }
                    $(globelsel).parent().parent().find('.value').html(html);
                }
                else{

                }
            },
            });
    }
</script>
@endsection
