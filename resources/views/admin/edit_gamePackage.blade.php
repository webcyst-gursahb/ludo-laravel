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
                        <form role="form" method="post" action="{{route('admin.updateGamePackage',$package->id)}}">
                            @csrf
                          <div class="col-md-6">
                            
                              <!-- text input -->
                              <div class="form-group">
                                <label>Amount</label>
                                <input type="text" class="form-control" placeholder="Enter Amount" name="amount"  value="{{$package->amount}}" required>
                              </div>
                              <div class="form-group">
                                <label>Admin Fee</label>
                                <input type="text" class="form-control" placeholder="Enter Admin Fee" name="admin_fee"  value="{{$package->admin_fee}}" >
                              </div>
                            <div class="form-group">
                              <label>Win Amount</label>
                              <input type="text" class="form-control" placeholder="Enter Win Amount" name="win_amount"   value="{{$package->win_amount}}" required>
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