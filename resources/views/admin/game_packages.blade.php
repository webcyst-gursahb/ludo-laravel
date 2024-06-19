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
                  <h3 class="card-title ">All Packages</h3>
                  <div class="card-tools">
                    <a href="{{route('admin.addPackage')}}" class="btn btn-success"> Add Package</a>
                </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table class="table ">
                    <thead>
                      <tr>
                        <th >#</th>
                        <th>Amount</th>
                        <th>Admin Fee</th>
                        <th>Win Amount</th>
                        <th style="min-width: 120px;">Date</th>
                        <th >Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($packages))
                        @foreach ($packages as $key=>$package)
                        <tr>
                            <td>{{$packages->firstItem()+$key}}</td>
                            <td>{{$package->amount}}</td>
                            <td>{{$package->admin_fee}}</td>
                            <td>{{$package->win_amount}}</td>
                            <td>{{$package->created_at}}</td>
                            <td class="d-flex" >
                                <a href="{{route('admin.editGamePackage',$package->id)}}" class="btn btn-warning btn-sm mr-2">Edit</a>
                                <a href="{{route('admin.deleteGamePackage',$package->id)}}" class="btn btn-danger btn-sm mr-2" onclick="return confirm('Are You sure want to Delete!')">Delete</a>
                            </td>
                              </tr>
                        @endforeach
                        @endif
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>
        </div>
    </section>
</div>
@endsection