@extends('layouts.admin_app')
   
@section('content')
<style>
  .b-30{
    border-radius:30px;
    text-align-last:end;
  }
</style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
          <div class="col-md-3">
            <div class="card b-30">
              <div class="card-body">
                <h5>Total Users</h5>
                <h5>{{$total_users}}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card b-30">
              <div class="card-body">
                <h5>Active Users</h5>
                <h5>{{$active_users}}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card b-30">
              <div class="card-body">
                <h5>Non Active Users</h5>
                <h5>{{$nonActive_users}}</h5>
              </div>
            </div>
          </div>
          <!-- <div class="col-md-3">
            <div class="card b-30">
              <div class="card-body">
                <h5>Total Binance Users</h5>
                <h5>{{$binance_users}}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card b-30">
              <div class="card-body">
                <h5>Total Bids</h5>
                <h5>{{$total_beds}}</h5>
              </div>
            </div>
          </div> -->
          <div class="col-md-3">
            <div class="card b-30">
              <div class="card-body">
                <h5>Total Balance</h5>
                <h5>{{$fuel_balance}}</h5>
              </div>
            </div>
          </div>
          {{-- <div class="col-md-3">
            <div class="card b-30">
              <div class="card-body">
                <h5>Total Income Balance</h5>
                <h5>{{$income_balance}}</h5>
              </div>
            </div>
          </div> --}}
          <div class="col-md-3">
            <div class="card b-30">
              <div class="card-body">
                <h5>Total Generation</h5>
                <h5>{{$total_generation}}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card b-30">
              <div class="card-body">
                <h5>Total Profit Generation</h5>
                <h5>{{$profit_generation}}</h5>
              </div>
            </div>
          </div>
          </div>
        </div>
      </section>
</div>
@endsection