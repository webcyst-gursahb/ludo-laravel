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
                  <h3 class="card-title ">All Transactions</h3>
                  <div class="card-tools">
                    <form class="form-inline ml-3 mt-2" action="" method="get">
                        <div class="input-group input-group-sm">
                          <input class="form-control form-control-navbar" type="search" placeholder="Search"  name="search">
                          <div class="input-group-append">
                            <button class="btn btn-success" type="submit">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th >#</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Wallet Type </th>
                        <th>Balance</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th style="min-width: 120px;">Date</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($transactions))
                        @foreach ($transactions as $key=>$trans)
                        <tr>
                            <td>{{$transactions->firstItem()+$key}}</td>
                            <td>{{$trans->user_name}}</td>
                            <td>{{$trans->user_email}}</td>
                            <td>Chips</td>
                            <td>{{$trans->amount}}</td>
                            <td>{{$trans->description}}</td>
                            <td>{{$trans->status == 0 ? "Credited":"Debited"}}</td>
                            <td>{{$trans->created_at}}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                  </table>
                  </div>
                  {{$transactions->links()}}
                </div>
              </div>
        </div>
    </section>
</div>
@endsection