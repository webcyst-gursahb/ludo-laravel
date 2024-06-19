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
                  <h4 class="card-title">Edit Package</h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="card-body">
                        <form role="form" method="post" action="{{route('admin.updatePackage',$package->id)}}">
                            @csrf
                          <div class="col-md-6">
                            
                              <!-- text input -->
                              <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name" name="name"  value="{{$package->name}}">
                              </div>
                              <div class="form-group">
                                <label>Amount</label>
                                <input type="text" class="form-control" placeholder="Enter Amount" name="amount" value="{{$package->amount}}">
                              </div>
                              <div class="form-group">
                                <label>Type</label>
                                <input type="text" class="form-control" placeholder="Enter Type"  name="type" value="{{$package->type}}">
                              </div>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                      </div>
                </div>
              </div>
        </div>
    </section>
</div>
@endsection