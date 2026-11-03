@extends('layouts.admin')

@section('content')
<div class="row" style="font-family: 'PT Serif', serif;">
    <div class="col-md-4 mb-3">
        <div class="card p-3 border-0 shadow-sm bg-white">
            <h6 class="text-muted">Total Products</h6>
            <h3 class="fw-bold text-primary mt-2">12</h3>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card p-3 border-0 shadow-sm bg-white">
            <h6 class="text-muted">Total Orders</h6>
            <h3 class="fw-bold text-success mt-2">5</h3>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card p-3 border-0 shadow-sm bg-white">
            <h6 class="text-muted">Registered Users</h6>
            <h3 class="fw-bold text-info mt-2">8</h3>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 p-4 mt-4 bg-white" style="font-family: 'PT Serif', serif;">
    <h4 class="fw-bold mb-3">Recent Activities</h4>
    <p class="text-muted"></p>
</div>
@endsection
