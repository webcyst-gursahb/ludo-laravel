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
                  <h3 class="card-title ">User Binance History</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Bid Id</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>From Coin Amount</th>
                        <th>From Coin</th>
                        <th>To Coin Amount</th>
                        <th>To Coin</th>
                        <th>Type</th>
                        <th>Profit</th>
                        <th style="min-width: 120px;">Date</th>
                        <th style="min-width: 147px;"></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($bids))
                        @foreach ($bids as $key=>$bid)
                        @if (Request()->type && Request()->type == "buy")
                        @if($bid->status_type=="buy" && $bid->sell_status == 0)
                        <tr>
                            <td>{{$bids->firstItem()+$key}}</td>
                            <td>{{$bid->bid_id}}</td>
                            <td>{{isset($bid->user->name) ? $bid->user->name : ""}}</td>
                            <td>{{isset($bid->user->email) ? $bid->user->email : ""}}</td>
                            <td>{{$bid->from_coin_quantity}}</td>
                            <td>{{$bid->from_coin}}</td>
                            <td>{{$bid->to_coin_quantity}}</td>
                            <td>{{$bid->to_coin}}</td>
                            <td>{{$bid->status_type}}</td>
                            <td>{{$bid->status_type=="buy"?$bid->profit:""}}</td>
                            <td>{{$bid->created_at}}</td>
                            <td><a href="{{route('admin.binanceBal',["id"=>$bid->user_id])}}" class="btn btn-primary mr-2">View Balance</a></td>
                            <td  class="d-flex">
                              @if($bid->sell_status == 0)
                              <form action="{{route('admin.postSell')}}" method="post" class="">
                                @csrf
                                <input type="hidden" name="users[]" value="{{$bid->user_id}}">
                                <input type="hidden" name="bid_id" value="{{$bid->bid_id}}">
                                <input type="hidden" name="from_coin" value="{{$bid->to_coin}}">
                                <input type="hidden" name="to_coin" value="{{$bid->from_coin}}">
                                <input type="hidden" name="quantity" value="{{$bid->to_coin_quantity}}">
                                <input type="hidden" name="prev_quantity" value="{{$bid->from_coin_quantity}}">
                                <input type="hidden" name="buy_price" value="{{$bid->from_coin_price}}">
                                <button class="btn btn-success" type="submit" name="type" value="sell" onclick="return confirm('Are You Sure want to sell!');">Sell</button>
                              </form>
                              <form action="{{route('admin.removeSell')}}" method="post" class="ml-2">
                                @csrf
                                <input type="hidden" name="users[]" value="{{$bid->user_id}}">
                                <input type="hidden" name="bid_id" value="{{$bid->bid_id}}">
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Are You Sure want to Deactivate!');">Remove</button>
                              </form>
                              @endif
                            </td>
                          </tr>
                          @endif
                        @else
                        <tr>
                            <td>{{$bids->firstItem()+$key}}</td>
                            <td>{{$bid->bid_id}}</td>
                            <td>{{isset($bid->user->name) ? $bid->user->name : ""}}</td>
                            <td>{{isset($bid->user->email) ? $bid->user->email : ""}}</td>
                            <td>{{$bid->from_coin_quantity}}</td>
                            <td>{{$bid->from_coin}}</td>
                            <td>{{$bid->to_coin_quantity}}</td>
                            <td>{{$bid->to_coin}}</td>
                            <td>{{$bid->status_type}}</td>
                            <td>{{$bid->status_type=="buy"?$bid->profit:""}}</td>
                            <td>{{$bid->created_at}}</td>
                            <td><a href="{{route('admin.binanceBal',["id"=>$bid->user_id])}}" class="btn btn-primary btn-sm">View Balance</a></td>
                          </tr>
                          
                          @endif
                        @endforeach
                        @endif
                    </tbody>
                </table>
                  </div>
                  {{$bids->links()}}
                </div>
              </div>
        </div><script></script>
    </section>
</div>
<script>

</script>
@endsection