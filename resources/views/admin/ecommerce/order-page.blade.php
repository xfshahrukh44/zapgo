@extends('layouts.app')
@push('before-css')
    <link href="{{ asset('assets/css/pages/order-page.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-8">
                                <div class="order-status">
                                    @if ($order->order_status == 'Pending')
                                        <ul>
                                            <li class="active-link">
                                                <div class="white-bg">
                                                    <div class="circle-top">
                                                        <div class="circle-1"></div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary disabled"><span>Pending</span></button>
                                            </li>

                                            <li class="non-active">
                                                <div class="white-bg">
                                                    <div class="circle-top">
                                                        <div class="circle-1"></div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary"><span>Completed</span>
                                            </li>
                                        </ul>
                                    @else
                                        <ul>
                                            <li class="non-active">
                                                <div class="white-bg">
                                                    <div class="circle-top">
                                                        <div class="circle-1"></div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary"><span>Pending</span></button>
                                            </li>

                                            <li class="active-link">
                                                <div class="white-bg">
                                                    <div class="circle-top">
                                                        <div class="circle-1"></div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary disabled"><span>Completed</span></button>
                                            </li>
                                        </ul>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="btn-group float-md-right d-block">
                                    <p class="alert alert-primary text-center">{{ $order->order_status }}</p>
                                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">Change Order Status</button>
                                    <div class="dropdown-menu arrow">
                                        <a href="javascript:void()"
                                            onclick="window.location.href='{{ route('status.pending', [$order->id]) }}'"
                                            class="dropdown-item">Pending
                                        </a>
                                        <a href="javascript:void()"
                                            onclick="window.location.href='{{ route('status.completed', [$order->id]) }}'"
                                            class="dropdown-item">Completed
                                        </a>
                                        <!-- <a href="javascript:void()"  onclick="window.location.href='{{ route('status.delivered', [$order->id]) }}'" class="dropdown-item">Delivered
                        </a>
                        <a href="javascript:void()"  onclick="window.location.href='{{ route('status.cancelled', [$order->id]) }}'" class="dropdown-item">Cancelled
                        </a> -->
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- ============================================================== -->
        <!-- End Info box -->

        <!--Delivery details -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex m-b-10 no-block">
                            <h5 class="card-title m-b-0 align-self-center text-uppercase">Order id {{ $order->id }}</h5>
                            <div class="ml-auto">
                                <ul class="list-inline m-t-5 text-muted text-uppercase lp-5 font-medium font-12">
                                    <li> {{ date('F d, Y', strtotime($order->created_at)) }}</li>

                                </ul>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table product-table color-table primary-table">
                                <thead>
                                    <tr>

                                        <th>ID </th>
                                        <th>Product</th>
                                        <th>&nbsp;</th>
                                        <th>Price</th>
                                        <th>QTY</th>
                                        <th>Total</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $subtotal = 0;
                                    $total_variation = 0;
                                    $count = 1;
                                    ?>

                                    @foreach ($order_products as $order_product)
                                    @php
                                        $product = App\Product::where('id', $order_product->order_products_product_id)->first();
                                        $order = App\orders::where('id', $order_product->orders_id)->first();
                                        $envFee = (float)$product->env_fee;
                                        $taxes = (float)$product->taxes;

                                        $start = new DateTime($order->start_date);
                                        $end = new DateTime($order->end_date);
                                        $interval = $start->diff($end);
                                        $day = $interval->days;

                                        $pricePerDay = (\App\ProductAttribute::where(['product_id' => $order_product->order_products_product_id, 'attribute_id' => 14])->first()->price) ?? 0.00;
                                        $pricePerWeek = (\App\ProductAttribute::where(['product_id' => $order_product->order_products_product_id, 'attribute_id' => 15])->first()->price) ?? 0.00;
                                        $pricePerMonth = (\App\ProductAttribute::where(['product_id' => $order_product->order_products_product_id, 'attribute_id' => 16])->first()->price) ?? 0.00;
                                        $priceFor35Days = (float)$pricePerMonth + (float)$pricePerWeek;
                                        $priceFor42Days = (float)$pricePerMonth + (float)$pricePerWeek * 2;
                                        $priceFor49Days = (float)$pricePerMonth + (float)$pricePerWeek * 3;
                                        $daysInMonth = 28;
                                        $daysInWeek = 7;
                                        $months = floor($day / $daysInMonth);
                                        $remainingDays = $day % $daysInMonth;
                                        $weeks = floor($remainingDays / $daysInWeek);
                                        $remainingDays = $remainingDays % $daysInWeek;
                                        $days = $remainingDays;

                                        $totalPriceTemp = ($months * $pricePerMonth) + ($weeks * $pricePerWeek) + ($days * $pricePerDay);

                                        $totalWeeks = ceil($day / $daysInWeek);
                                        $totalMonths = ceil($day / $daysInMonth);

                                        $priceByWeeks = $totalWeeks * $pricePerWeek;
                                        $priceByMonths = $totalMonths * $pricePerMonth;

                                        $totalPrice = min($totalPriceTemp, $priceByWeeks, $priceByMonths);

                                        if ($day > 30 && $day <= 35) {
                                            $totalPrice = min($totalPrice, $priceFor35Days);
                                            if ($totalPrice > $pricePerMonth * 2) {
                                                $totalPrice = $pricePerMonth * 2;
                                            }
                                        } elseif ($day > 35 && $day <= 42) {
                                            $totalPrice = min($totalPrice, $priceFor42Days);
                                            if ($totalPrice > $pricePerMonth * 2) {
                                                $totalPrice = $pricePerMonth * 2;
                                            }
                                        } elseif ($day > 42 && $day <= 49) {
                                            $totalPrice = min($totalPrice, $priceFor49Days);
                                            if ($totalPrice > $pricePerMonth * 2) {
                                                $totalPrice = $pricePerMonth * 2;
                                            }
                                        }


                                        $itemTotalPrice = $totalPrice * $order_product->order_products_qty;

                                        $envFeeFinal = ($envFee / 100) * $itemTotalPrice;
                                        $taxFinal = ($taxes / 100) * $itemTotalPrice;

                                        $total_price = number_format($itemTotalPrice, 2, '.', '');
                                        $env_fee_final = number_format($envFeeFinal, 2, '.', '');
                                        $tax_final = number_format($taxFinal, 2, '.', '');
                                    @endphp
                                        <tr>

                                            <td>{{ $order_product->order_products_id }}</td>
                                            <td><img src="{{ asset($product->image) }}" alt="" title=""
                                                    width="200"> </td>

                                            <td class="text-dark weight-600">
                                                {{ $order_product->order_products_name }}
                                            </td>
                                            <td>${!! number_format($order_product->order_products_price, 2) !!}</td>
                                            <td>{{ $order_product->order_products_qty }}</td>
                                            <td>${{ number_format($itemTotalPrice, 2) }}</td>

                                        </tr>

                                        @php
                                            $subtotal += $total_price + $env_fee_final + $tax_final;
                                            $env_check += $env_fee_final;
                                            $tax_check += $tax_final;
                                            $count++;
                                        @endphp
                                    @endforeach

                                    @php
                                        $otherFees = App\Http\Traits\HelperTrait::returnFlag(1977);
                                        $rentalProtection = App\Http\Traits\HelperTrait::returnFlag(1975);
                                        $deliveryFee = App\Http\Traits\HelperTrait::returnFlag(1974);

                                        $otherFees_final = ($otherFees / 100) * $subtotal;
                                        $rentalProtection_final = ($rentalProtection / 100) * $subtotal;
                                    @endphp

                                    <tr>
                                      <td></td>
                                      <td>&nbsp;</td>
                                      <td>Round-trip delivery</td>
                                      <td>---</td>
                                      <td>---</td>
                                      <td>${!! number_format($deliveryFee, 2) !!}</td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td>&nbsp;</td>
                                      <td>Rental protection plan</td>
                                      <td>---</td>
                                      <td>---</td>
                                      <td>${!! number_format($rentalProtection_final, 2) !!}</td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td>&nbsp;</td>
                                      <td>Environmental Service Fee</td>
                                      <td>---</td>
                                      <td>---</td>
                                      <td>${!! number_format($env_check, 2) !!}</td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td>&nbsp;</td>
                                      <td>Other fees</td>
                                      <td>---</td>
                                      <td>---</td>
                                      <td>${!! number_format($otherFees_final, 2) !!}</td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td>&nbsp;</td>
                                      <td>Taxes</td>
                                      <td>---</td>
                                      <td>---</td>
                                      <td>${!! number_format($tax_check, 2) !!}</td>
                                    </tr>

                                    @php
                                        $estimatedSubtotal = ($subtotal + $rentalProtection_final + $otherFees_final + $deliveryFee);
                                    @endphp
                                    @if($order->order_shipping)
                                    <tr>
                                        <td colspan="2" class="custom-product">&nbsp;</td>
                                        <td colspan="3" class="text-muted custom-product">Shipping:
                                        </td>
                                        <td class="custom-product">${!! number_format($order->order_shipping, 2) !!}</td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td class="no-border" colspan="2">&nbsp;</td>
                                        <td colspan="3" class="text-dark no-border weight-600">Total Price:
                                        </td>
                                        <?php
                                            $shipping = $order->order_shipping ;
                                        ?>
                                        <td class="no-border">${!! number_format($estimatedSubtotal  + $shipping, 2) !!}</td>

                                    </tr>





                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-5 align-self-center text-uppercase">Customer Details</h5>


                        <div class="product-table text-dark no-border">
                            <table class="table m-b-5 m-t-20 ">
                                <tbody>
                                    <tr>
                                        <td class="text-muted">Recipient: </td>
                                        <td class="text-color">{{ $order->delivery_first_name }}
                                            {{ $order->delivery_last_name }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-muted">Phone: </td>
                                      <td class="text-color">{{ $orderProduct->phone }}</td>
                                    </tr>
                                    <tr>
                                      <td class="text-muted">Email: </td>
                                      <td class="text-color">{{ $orderProduct->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Address: </td>
                                        <td class="text-color">
                                            {{ $order->delivery_address_1 }},{{ $order->delivery_country }}
                                            {{ $order->delivery_city }}, {{ $order->delivery_state }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">State: </td>
                                        <td class="text-color">{{ $order->delivery_state }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">City: </td>
                                        <td class="text-color">{{ $order->delivery_city }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Zip: </td>
                                        <td class="text-color">{{ $order->delivery_zip_code }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-5 align-self-center text-uppercase">Order Information</h5>


                        <div class="product-table text-dark no-border">
                            <table class="table m-b-5 m-t-20 ">
                                <tbody>
                                  <tr>
                                    <td class="text-muted">Payment Method: </td>
                                    <td class="text-color">{{ ucfirst($order->payment_method) }}</td>
                                  </tr>
                                  <tr>
                                    <td class="text-muted">Transaction Id: </td>
                                    <td class="text-color">{{ $order->transaction_id }}</td>
                                  </tr>
                                  <tr>
                                    <td class="text-muted">Invoice Number: </td>
                                    <td class="text-color">{{ $order->invoice_number }}</td>
                                  </tr>
                                  <tr>
                                      <td class="text-muted">Order Date: </td>
                                      <td class="text-color">{{date('d F, Y',strtotime($order->created_at))}}</td>
                                  </tr>
                                  <tr>
                                      <td class="text-muted">Date Range: </td>
                                      <td class="text-color">{{ $order->start_date . ' to ' . $order->end_date }}</td>
                                  </tr>
                                  @php
                                        $start_date = \Carbon\Carbon::parse($order->start_date);
                                        $end_date = \Carbon\Carbon::parse($order->end_date);
                                        $difference_in_days = $start_date->diffInDays($end_date);
                                    @endphp
                                  <tr>
                                      <td class="text-muted">Number of Days: </td>
                                      <td class="text-color">{{ $difference_in_days }}</td>
                                  </tr>
                                  <tr>
                                      <td class="text-muted">Delivery Time: </td>
                                      <td class="text-color">{{ $order->delivery_time }}</td>
                                  </tr>
                                  <tr>
                                      <td class="text-muted">Recovery Time: </td>
                                      <td class="text-color">{{ $order->pickup_time }}</td>
                                  </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

            </div>
            <!-- Column -->
        </div>
    </div>
@endsection


@push('js')
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--c3 JavaScript -->
    <script src="{{ asset('plugins/vendors/d3/d3.min.js') }}"></script>
    <script src="{{ asset('plugins/vendors/c3-master/c3.min.js') }}"></script>
    <!--jquery knob -->
    <script src="{{ asset('plugins/vendors/knob/jquery.knob.js') }}"></script>
    <!--Sparkline JavaScript -->
    <script src="{{ asset('plugins/vendors/sparkline/jquery.sparkline.min.js') }}"></script>
    <!--Morris JavaScript -->
    <script src="{{ asset('plugins/vendors/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('plugins/vendors/morrisjs/morris.js') }}"></script>
    <!-- Popup message jquery -->
    <script src="{{ asset('plugins/vendors/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('plugins/vendors/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(function() {
            $('#myTable').DataTable();
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 18,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group +
                                '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });

        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
    <script>
        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    console.log(i)
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }
    </script>

    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{ asset('plugins/vendors/styleswitcher/jQuery.style.switcher.js') }}"></script>
@endpush
