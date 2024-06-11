@extends('layouts.main')
@section('title', 'Product')
@section('css')

@endsection

@section('content')

<?php $segment = Request::segments(); ?>

<section class="rent-sec about-inner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="equipment">
                    <h1><span class="d-block">Product</span></h1>
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
                                                <h2>View Product</h2>
                                            </div>
                                            
                                            <a href="{{ route('add_product') }}" class="btn btn-success" style="margin: 9px 0 9px 0;">Add Product</a>
                                            <div class="search-form mb-4">
                                                <form action="{{ route('view_product') }}" method="GET">
                                                    <div class="input-group">
                                                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request()->query('search') }}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" type="submit">Search</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Product Title</th>
                                                            <th>Product Price</th>
                                                            <th>Product Category</th>
                                                            <th>Product Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                    @if($products->count())
                                                        @php
                                                            $count = 1;
                                                        @endphp
                                                        @foreach($products as $product)
                                                            <tr>
                                                                <td>{{ $count }}</td>
                                                                <td>{{ \Illuminate\Support\Str::limit($product->product_title, 50, $end='...') }}</td>
                                                                <td>{{ $product->price }}</td>
                                                                <td>{{ $product->categorys->name }}</td>
                                                                <td>
                                                                    <img src="{{asset($product->image)}}" alt="{{ $product->product_title }}" style="width: 50px; height: 50px;">
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('edit_product', $product->id) }}" class="btn btn-primary">Edit</a>
                                                                    <form action="{{ route('delete_product', $product->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $count++;
                                                            @endphp
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="6">No products found.</td>
                                                        </tr>
                                                    @endif

                                                    </tbody>
                                                </table>
                                                {{ $products->links() }} <!-- Pagination links -->
                                            </div>                                            
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
    .thead-light tr th {
        background: #0092d7;
    }
</style>

@section('js')
<script type="text/javascript">
     $(document).on('click', ".btn1", function(e){
            // alert('it works');
            $('.loginForm').submit();
     });
</script>
@endsection
