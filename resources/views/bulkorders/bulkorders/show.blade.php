@extends('layouts.app')

@section('content')
    <div class="container-fluid bg-white mt-5">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box card">
                <div class="card-body">
                    <h3 class="box-title pull-left">Bulkorder {{ $bulkorder->id }}</h3>

                        <a class="btn btn-success pull-right" href="{{ url('/bulkorders/bulkorders') }}">
                            <i class="icon-arrow-left-circle" aria-hidden="true"></i> Back</a>

                    <div class="clearfix"></div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $bulkorder->id }}</td>
                            </tr>
                            <tr>
                                <th> Customer Name </th>
                                <td> {{ $bulkorder->customer_name }} </td>
                            </tr>
                            <tr>
                                <th> Customer Email </th>
                                <td> {{ $bulkorder->customer_email }} </td>
                            </tr>
                            <tr>
                                <th> Customer Phone </th>
                                <td> {{ $bulkorder->customer_phone }} </td>
                            </tr>
                            {{-- <tr>
                                <th> Product Name </th>
                                <td> {{ $bulkorder->product_name }} </td>
                            </tr>
                            <tr>
                                <th> Quantity </th>
                                <td> {{ $bulkorder->quantity }} </td>
                            </tr> --}}
                            <tr>
                                <th> Amount </th>
                                <td> ${{ $bulkorder->amount }} </td>
                            </tr>
                            <tr>
                                <th> Transaction ID </th>
                                <td> {{ $bulkorder->transaction_id }} </td>
                            </tr>
                            <tr>
                                <th> Status </th>
                                <td> {{ $bulkorder->status }} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (!empty($bulkorder->quote_prod_ids))
                @php
                    $quote_prod_arr = explode(',', $bulkorder->quote_prod_ids);
                @endphp
                @foreach ($quote_prod_arr as $val)
                @php
                    $data = App\Models\QuoteProdInfo::find($val);
                @endphp
                <div class="col-md-6">
                    <div class="white-box card">
                        <div class="card-body">
                            <div class="order-detail">
                                <h3>Product Detail</h3>
                                <div class="order-box">
                                    <div class="pname item">
                                        <h4>Item Name: </h4>
                                        <h4>{{ $data->product_title }}</h4>
                                    </div>
                                    <div class="pname item">
                                        <h4>Item Price: </h4>
                                        <h4>$<span id="price">{{ $data->product_price }}</span></h4>
                                    </div>
                                    <div class="pname item">
                                        <h4>Quantity: </h4>
                                        <h4>{{ $data->quantity }}</h4>
                                    </div>
                                    <div class="price item">
                                        <h5>Total: </h5>
                                            <h4>$<span id="total">{{ $data->price }}</span></h4>            
                                    </div>
                                </div>
                            </div>
                        </div>
            
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

</div>
<style>
    .item h4,
    .item h5 {
        margin: 0px !important;
    }

    .item {
        margin-bottom: 10px;
        border-bottom: 1px solid #e3ebf3;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>
@endsection

