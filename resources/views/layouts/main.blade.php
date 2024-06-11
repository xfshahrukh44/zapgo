<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Admin">
        <meta name="author" content="Admin">
		<meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset(!empty($favicon->img_path)?$favicon->img_path:'')}}">
        <title>{{ config('app.name') }}</title>
        <!-- ============================================================== -->
        <!-- All CSS LINKS IN BELOW FILE -->
        <!-- ============================================================== -->
        @include('layouts.front.css')
        @yield('css')
        <style>

/*.image {*/
/*    padding-top: 50px;*/
/*    padding-bottom: 50px;*/
/*}*/

.date-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

form#update-cart {
    padding: 0px;
}

ul.total-row li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0px;
    border-bottom: 1px solid #eee;
}

ul.total-row {
    padding: 50px 0px;
}



.sidebar-minus {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--blue-color);
    border-radius: 50%;
    cursor: pointer;
    color: white;
    font: 30px/1 Arial, sans-serif;
    text-align: center;
}

.sidebar-plus{
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--blue-color);
    border-radius: 50%;
    cursor: pointer;
    color: white;
    font: 30px/1 Arial, sans-serif;
    text-align: center;
}



.cart-items .quantity.qty {
    padding-top: 10px;
    width: 100%;
}

p.days {
    padding-top: 10px;
}

.quantity .qty input{
    text-align: cenetr;
}

.image img {
    width: 100%;
    /*margin-left: 80px;*/
}

.duration input {
    width: 150px;

}

.image {
    width: 100px;
    height: 100px;
}

.image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.cart-items h3 {
    font-family: FontsFree-Net-BebasNeueBold;
    font-size: 20px;
    text-align: left;
}

.cart-items {
    padding-top: 20px;
    align-items: center;
    position: relative;
}


.delete-cart {
    display: flex;
    align-items: end;
    justify-content: end;
    position: absolute;
}

.delete-cart a {
    color: #c91d22;
    font-size: 20px;
}


.text p
{
    text-align: left;
    font-weight: 400;
}
.button {
    margin-top: 30px;
}


.row.cart-items {
    padding-bottom: 20px;
    border-bottom: 1px solid black;
}


            .myaccount-tab-menu.nav a {
                display: block;
                padding: 15px 32px;
                font-size: 16px;
                align-items: center;
                width: 100%;
                font-weight: bold;
                color: black;
                border-radius: 50px;
                margin-top: 15px;
                border: 1px solid;
            }
            .myaccount-tab-menu.nav a i {
                padding-right: 10px;
            }

            .myaccount-tab-menu.nav {

                border-radius:10px;

            }

            .myaccount-tab-menu.nav .active, .myaccount-tab-menu.nav a:hover {
                background: var(--blue-color);
                color: white;
            }


p.text {
    color: black;
    font-weight: 900;
    margin-left: 20px;
    font-size: 20px;
}

            .rent-sec {
  background-image: url({{ asset('images/2.png') }}) !important;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  height: 800px;
  display: flex;
  align-items: center;
  position: relative;
  z-index: 0;
}

.about-inner {
  height: 400px;
  align-items: end;
}

            .account-details-form label.required {
                width: 100%;
                font-weight: 500;
                font-size: 18px;
            }
            .account-details-form input[type=text],
            .account-details-form input[type=email],
            .account-details-form input[type=password],
            .account-details-form select {
                border-width: 1px;
                border-color: white;
                border-style: solid;
                padding-left: 15px;
                color: black;
                width: 100%;
                border-radius: 3px;
                background-color: rgb(255, 255, 255);
                height: 52px;
                padding-left: 15px;
                margin-bottom: 30px;
                color: #000000;
                font-size: 15px;
                border: 1px solid;
            }
            .account-details-form legend {
                font-family: CottonCandies;
                font-size: 50px;
            }
            .editable {
                position: relative;
            }
            .editable-wrapper {
                position: absolute;
                right: 0px;
                top: -50px;
            }
            #updateProfile {
    background: var(--blue-color);
    padding: 15px 32px;
    color: white;
    border-radius: 10px;
}
.my-account-wrapper {
    margin-top: 40px;
}
.myaccount-content
{
    margin-top: 12px;
}

            .editable-wrapper a {
                background-color: #17a2b8;
                border-radius: 50px;
                width: 35px;
                height: 35px;
                display: inline-block;
                text-align: center;
                line-height: 35px;
                color: white;
                margin-left: 10px;
                font-size: 16px;
            }
            .editable-wrapper a.edit{
                background-color: #007bff;
            }
            /* #footer-form,#feedback-form {
                display: none;
            } */

            button#addCart {
                display: block;
                background: transparent;
                border: 2px solid #0285c4;
                color: #0285c4 !important;
                font-weight: 700;
                font-size: 20px;
                margin: 10px 0;
                width: 100%;
            }


            .but-cs{
                display: block;
                background: transparent;
                border: 2px solid #0285c4;
                color: #0285c4 !important;
                font-weight: 700;
                font-size: 20px;
                margin: 10px 0;
                width: 100%;
            }

            a.cart_icons {
                position: relative;
            }

            span.cart_counts {
                position: absolute;
                top: -30%;
                left: 80%;
                background: #000;
                color: #fff;
                padding: 1px 10px;
                border-radius: 25px;
            }

            button#outofstock {
                width: 100%;
                font-size: 20px;
                margin: 0;
            }
            
            .h-p div {
                display: flex;
                align-items: center;
                gap: 10px;
                flex-wrap: wrap;
            }
            
            .h-p div img {
                height: 100px;
                width: 100px;
            }
        </style>
    </head>
    <body class="responsive">


        @include('layouts/front.header')




        @yield('content')


        @include('layouts/front.footer')
        <!-- ============================================================== -->
        <!-- All SCRIPTS ANS JS LINKS IN BELOW FILE -->
        <!-- ============================================================== -->
        @include('layouts/front.scripts')
        @yield('js')

    </body>
</html>
