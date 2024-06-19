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
                  <h4 class="card-title">Send Epin Balance</h4>
                    {{-- <div class="card-tools">
                        <div class="badge badge-primary">Balance: {{$balance}}</div>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="card-body">
                        <form role="form" method="post" action="{{route('admin.postEpin',$id)}}">
                            @csrf
                          <div class="col-md-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Amount</label>
                                <input type="text" class="form-control" placeholder="Enter Amount" name="amount"  required>
                              </div>
                              <div class="form-group">
                                <label>Description</label>
                                <textarea rows="3" class="form-control" placeholder="Enter Descripiton" name="desc"></textarea>
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