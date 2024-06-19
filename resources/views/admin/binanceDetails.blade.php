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
            
              <div class="card mt-5">
                <div class="card-header">
                    <h2 class="card-title">Binance Details</h2>
                  <div class="card-tools d-flex">
                    {{-- <form class="form-inline " action="" method="get">
                        <div class="input-group input-group-sm">
                          <input class="form-control form-control-navbar" type="search" placeholder="Search From Coin"  name="search_from">
                          <div class="input-group-append">
                            <button class="btn btn-success" type="submit">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </form> --}}
                    <form class="form-inline ml-3" action="" method="get">
                        <div class="input-group input-group-sm">
                          <input class="form-control form-control-navbar" type="search" placeholder="Search To Coin"  name="search_to">
                          <div class="input-group-append">
                            <button class="btn btn-success" type="submit">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    {{-- <th>From Amount</th> --}}
                    <th>Bid Id</th>
                    <th>From Coin Price</th>
                    <th>From Coin</th>
                    {{-- <th>To Amount</th> --}}
                    <th>To Coin</th>
                    <th>Is Sell</th>
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
                      <td>{{$bed->from_coin_price}}</td>
                      <td>{{$bed->from_coin}}</td>
                      <td>{{$bed->to_coin}}</td>
                      <td>{{$bed->sell_from_coin == ""? "No":"Yes"}}</td>
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