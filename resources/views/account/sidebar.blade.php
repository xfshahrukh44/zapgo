
<div class="col-lg-3 col-md-4">
    <div class="myaccount-tab-menu nav" role="tablist">
        <a  href="{{ URL('account') }}" class="<?php echo (isset($segment[0]) AND $segment[0] == 'account')  ? 'active' : '' ?>"><i class="fas fa-th"></i>
            Dashboard</a>

        <a href="{{ URL('orders') }}" class="<?php echo (isset($segment[0]) AND $segment[0] == 'orders')  ? 'active' : '' ?>"><i class="fa fa-cart-arrow-down"></i> Orders History</a>
        @if (Auth::user()->role == 2)

        <a href="{{ URL('quotes') }}" class="<?php echo (isset($segment[0]) AND $segment[0] == 'quotes')  ? 'active' : '' ?>"><i class="fa fa-cart-arrow-down"></i> Get A Quote</a>
        @else
        <a href="{{ URL('view-product') }}" class="<?php echo (isset($segment[0]) AND $segment[0] == 'view-product')  ? 'active' : '' ?>"><i class="fa fa-cart-arrow-down"></i> View/Add Product</a>
        @endif

        <a href="{{ URL('account-detail') }}" class="<?php echo (isset($segment[0]) AND $segment[0] == 'account-detail')  ? 'active' : '' ?>"><i class="fa fa-user"></i> Account Details</a>

        <a href="{{ URL('signout') }}"><i class="fas fa-arrow-circle-left"></i> Logout</a>
    </div>
</div>
