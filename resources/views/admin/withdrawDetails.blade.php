@extends('layouts.admin_app')
   
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title ">Withdraw Details</h3>
                  <div class="card-tools d-flex mt-1">
                    {{-- <form class="form-inline ml-3" action="" method="get">
                        <div class="input-group input-group-sm">
                          <input class="form-control form-control-navbar" type="search" placeholder="Search"  name="search">
                          <div class="input-group-append">
                            <button class="btn btn-success" type="submit">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </form> --}}
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table class="table ">
                    <thead>
                      <tr>
                        <th >#</th>
                        <th>User Name</th>
                        <th>User UID</th>
                        <th>Amount</th>
                        <th>Wallet Type</th>
                        <th>Status</th>
                        <th style="min-width: 120px;">Date</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($withs))
                        @foreach ($withs as $key=>$with)
                        <tr>
                            <td>{{$withs->firstItem()+$key}}</td>
                            <td>{{$with->user_name}}</td>
                            <td>{{$with->user_UID}}</td>
                            <td>{{$with->amount}}</td>
                            <td>{{$with->wallet_type=="F"?"Chip":"E-Wallet"}}</td>
                            <td>{{$with->status==0?'Pending':($with->status==1?"Accepted":"Rejected")}}</td>
                            <td>{{$with->created_at}}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                  </table>
                  {{$withs->links()}}
                  </div>
                </div>
              </div>
        </div>
    </section>
</div>
@endsection