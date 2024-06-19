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
                  <h3 class="card-title ">All Users</h3>
                  <div class="card-tools d-flex mt-1">
                    <form class="form-inline ml-3" action="" method="get">
                        <div class="input-group input-group-sm">
                          <input class="form-control form-control-navbar" type="search" placeholder="Search By Sponser Id"  name="sponser_search">
                          <div class="input-group-append">
                            <button class="btn btn-success" type="submit">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                    <form class="form-inline ml-3" action="" method="get">
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
                  <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th >#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>UID</th>
                        <th> Balance</th>
                        <th>Epin Balance</th>
                        <th>Sponser Name</th>
                        <th>Sponser UID</th> 
                        {{-- <th>Rank</th> 
                        <th>Rank Level</th>  --}}
                        <th>Package Activated</th>
                        <th> Activation Date</th>
                        <th style="min-width:120px;">Date</th>
                        <th style="min-width:200px;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($users))
                        @foreach ($users as $key=>$user)
                        <tr>
                            <td>{{$users->firstItem()+$key}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->showPass}}</td>
                            <td>{{$user->uid}}</td>
                            <td>{{$user->fuel_balance}}</td>
                             <td>{{$user->epin_balance}}</td>
                            <td>{{$user->sp_name}}</td>
                            <td>{{$user->spid==null?"Admin":$user->spid}}</td>
                            {{-- <td>{{$user->rank}}</td> 
                            <td>{{$user->rank_level}}</td>  --}}
                            <td>{{$user->is_active == 1 ? "Yes":"No"}}</td>
                            <td>{{$user->activation_date}}</td>
                            <td>{{$user->created_at}}</td>
                            <td class="d-flex" >
                                <a href="{{route('admin.editUser',$user->id)}}" class="btn btn-warning btn-sm mr-2">Edit</a>
                                <a href="{{route('admin.sendBal',$user->id)}}" class="btn btn-info btn-sm mr-2">Send Balance</a>
                                {{-- <a href="" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete');">Delete</a> --}}
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                  </table>
                  {{$users->links()}}
                </div>
              </div>
        </div>
    </section>
</div>
@endsection