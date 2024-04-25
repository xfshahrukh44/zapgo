@extends('layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Contact Inquiries #{{ $inquiry->id }}</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                    <li class="breadcrumb-item active">Contact Inquiries</li>
                    <li class="breadcrumb-item active">View Inquiries #{{ $inquiry->id }}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-4 col-12">
        <div class="btn-group float-md-right">
            <a class="btn btn-info mb-1" href="{{ url('/admin/contact/inquiries') }}">Back</a>
        </div>
    </div>
</div>
<div class="content-body">
    <section id="basic-form-layouts">
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Inquiry View Page #{{ $inquiry->id }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr><th>ID</th><td>{{ $inquiry->id }}</td></tr>
                                    <tr><th>Name</th><td>{{ $inquiry->name }}</td></tr>
                                    <tr><th>Email</th><td>{{ $inquiry->email }}</td></tr>
                                    <tr><th>Phone Number</th><td>{{ $inquiry->phone }}</td></tr>
                                    <tr><th>Company Name</th><td>{{ $inquiry->company_name }}</td></tr>
                                    <tr><th>Subject</th><td>{{ $inquiry->subject }}</td></tr>
                                    <tr><th>Message</th><td>{{ $inquiry->message }}</td></tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

