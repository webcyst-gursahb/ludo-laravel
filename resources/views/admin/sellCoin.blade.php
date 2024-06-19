@extends('layouts.admin_app')
   
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
         
          @if (session('log') && !empty(session('log')))
            @foreach (session('log') as $sess)
                <div class="alert alert-success">{{$sess->description}}</div>
            @endforeach 
          @endif
            @if (session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title ">Sell Coin</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table class="table ">
                    <thead>
                      <tr>
                        <th>#</th>
                        {{-- <th>Bid Id</th>/ --}}
                        <th>From Coin</th>
                        <th>To Coin</th>
                        <th> Buy Coin Price</th>
                        <th> Current Price</th>
                        <th> Coin Amount</th>
                        <th>Date</th>
                        <th style="min-width: 147px;">Action</th>
                        <th style="min-width: 147px;"></th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($beds))
                        @foreach ($beds as $key=>$bed)
                        <tr>
                            <td>{{$beds->firstItem()+$key}}</td>
                            {{-- <td>{{$bed->id}}</td> --}}
                            <td class="from_coin">{{$bed->to_coin}}</td>
                            <td >{{$bed->from_coin}}</td>
                            <td>${{$bed->from_coin_price}}</td>
                            <td class="{{$bed->to_coin.$bed->from_coin}}">${{$bed->current_price}}</td>
                            <td>{{$bed->to_coin_quantity}}</td> 
                            <td>{{$bed->created_at}}</td>
                            <td class="d-flex">
                              <form action="{{route('admin.postSell')}}" method="post">
                                @csrf
                                @php
                                    // $users = App\User::where("api_key","!=","")->where("secret_key","!=","")->where("is_admin","!=",1)->get();
                                  // $bidId = 'bid'.$bed->bid_id;
                                  $users = $bed['users'];
                                @endphp 
                                @foreach ($users as $user)
                                <input type="hidden" name="users[]" value="{{$user->user_id}}">
                                @endforeach
                                <input type="hidden" name="bid_id" value="{{$bed->bid_id}}">
                                <input type="hidden" name="from_coin" value="{{$bed->to_coin}}">
                                <input type="hidden" name="to_coin" value="{{$bed->from_coin}}">
                                <input type="hidden" name="quantity" value="{{$bed->to_coin_quantity}}">
                                <input type="hidden" name="prev_quantity" value="{{$bed->from_coin_quantity}}">
                                <input type="hidden" name="buy_price" value="{{$bed->from_coin_price}}">
                                  <button class="btn btn-primary" type="submit" name="type" value="sell" onclick="return confirm('Are You Sure want to sell!');">Sell</button>
                              </form>
                              <form action="{{route('admin.removeBid')}}" method="post" class="ml-2">
                                @csrf
                                {{-- @foreach ($users as $user) --}}
                                <input type="hidden" name="users[]" value="{{$bed->user_id}}">
                                {{-- @endforeach --}}
                                <input type="hidden" name="bid_id" value="{{$bed->bid_id}}">
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Are You Sure want to Remove!');">Remove</button>
                              </form>
                            </td>
                            <td><a href="{{route('admin.binanceHistory',["id"=>$bed->bid_id,'type'=>"buy"])}}" class="btn btn-success" name="type" value="buy">View Users</a></td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                </div>
                  {{-- {{$beds->links()}} --}}
                </div>
              </div>
              <div class="card mt-5">
                <div class="card-header">
                  <h3>Sell History</h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    {{-- <th>From Amount</th> --}}
                    <th>Bid Id</th>
                    <th>From Coin</th>
                    {{-- <th>To Amount</th> --}}
                    <th>To Coin</th>
                    {{-- <th>From Amount</th>
                    <th>To Amount</th> --}}
                    <th style="min-width: 120px;">Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($sells))
                  @foreach ($sells as $bed)
                  <tr>
                      {{-- <td>{{$bed->to_coin_quantity}}</td> --}}
                      <td>{{$bed->id}}</td>
                      <td>{{$bed->from_coin}}</td>
                      <td>{{$bed->to_coin}}</td>
                      <td>{{$bed->created_at}}</td>
                        {{-- <td>{{$bed->from_coin_quantity}}</td> --}}
                      <td><a href="{{route('admin.binanceHistory',["id"=>$bed->id])}}" class="btn btn-success" name="type" value="sell">View Users</a></td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
              </table>
                </div>
                @if (!empty($sells))
                    {{$sells->links()}}
                @endif
              </div>
          </div>
        </div>
    </section>
</div>
<script>
  var conn = new WebSocket('wss://stream.binance.com:9443/ws/!ticker@arr');
  conn.onopen = function(e) {
      console.log("Connection established!");
  };
  conn.onmessage = function(e) {
      var datas = JSON.parse(e.data);
      $.each(datas,function(i,val){
          var price = val.c;
          var symbol = val.s;
          if(price<0){
              price = -price;
          }
          $("."+symbol).text("");
          $("."+symbol).text('$'+price);
          // $("."+symbol).fadeOut(500);
          // $("."+symbol).fadeIn(500);
      });
     
  };
</script>
<script>
  
  $(document).ready(function(){
  // setInterval(function(){
  //       $.get({
  //           url:"{{route('getPrice')}}",
  //           success:function(data){
  //             console.log(data);
  //             $.each(data,function(i,val){
  //               $("."+val.symbol).text("");
  //               $("."+val.symbol).text('$'+val.price);
  //               $("."+val.symbol).fadeOut(500);
  //               $("."+val.symbol).fadeIn(500);
  //             });
  //               console.log(data);
  //           }
  //       });
  //   },10000);


  
  $(".deactivate").click(function(){
   
    $(".myform").submit();
  });
});
</script>
@endsection