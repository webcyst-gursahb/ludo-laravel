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
                  <h4 class="card-title">Update Coin</h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="card-body">
                        <form role="form" method="post" action="{{route('binance.updateCoin',$coin->id)}}">
                        @csrf
                          <div class="col-md-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Coin Name</label>
                                <input type="text" class="form-control" placeholder="Coin Name" value="{{$coin->coin_name}}" readonly>
                              </div>
                              <div class="form-group">
                                <label>Secret Key</label>
                                <input type="text" class="form-control" placeholder="Enter Coin value" name="value" value="{{$coin->value}}" required>
                              </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                      </div>
                </div>
              </div>
        </div>
    </section>
</div>
@endsection