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
                  <h4 >Edit User</h4>
  
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="card-body">
                        <form role="form" method="post" action="{{route('admin.updateUser',['id'=>$user->id])}}">
                            @csrf
                          <div class="col-md-6">
                            
                              <!-- text input -->
                              <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name" name="name" value="{{$user->name}}" required>
                              </div>
                              <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Enter Email" name="email" value="{{$user->email}}" required>
                              </div>
                          
                              <div class="form-group">
                                <label>Phone</label>
                                <input type="phone" class="form-control" placeholder="Enter Phone" name="phone" value="{{$user->phone}}" >
                              </div>
                          
                              <!-- textarea -->
                              <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Enter Password" name="password" >
                              </div>
                              {{-- <div class="form-group">
                                <label>APi Key</label>
                                <input type="text" class="form-control" placeholder="Enter Api Key" name="api_key" value="{{$user->api_key}}" >
                              </div>
                              <div class="form-group">
                                <label>Secret Key</label>
                                <input type="text" class="form-control" placeholder="Enter Secret Key" name="secret_key" value="{{$user->secret_key}}" >
                              </div> --}}
                              {{-- <div class="form-group">
                                <label>Rank</label>
                                <input type="text" class="form-control" placeholder="Enter Rank" name="rank" value="{{$user->rank}}" >
                              </div> --}}
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                      </div>
                </div>
              </div>
        </div>
    </section>
</div>
@endsection