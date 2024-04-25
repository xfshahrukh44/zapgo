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
                            <tr>
                                <th> Product Name </th>
                                <td> {{ $bulkorder->product_name }} </td>
                            </tr>
                            <tr>
                                <th> Quantity </th>
                                <td> {{ $bulkorder->quantity }} </td>
                            </tr>
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
        </div>
    </div>

</div>
@endsection

