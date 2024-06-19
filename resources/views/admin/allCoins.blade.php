@extends('layouts.admin_app')
   
@section('content')
<style>
  .wid-50{
    width:50%;
  }
  .bottom{
    position: fixed;
    bottom: 0px;
    z-index: 1;
    width: 100%;
    background: white;
    padding: 10px;
  }
  @media only screen and (max-width:750px){
    .wid-50{
      width:100%;
    }
  }
</style>
<div class="content-wrapper" style="min-height:auto;">
    <section class="content">
        <div class="container-fluid">
          
            @if (session('logs') && !empty(session('logs')))
              @foreach (session('logs') as $sess)
              <div class="alert alert-success">{{$sess->description}}</div>
              @endforeach 
            @endif
            @if (session('error_logs') && !empty(session('error_logs')))
              @foreach (session('error_logs') as $sess)
              <div class="alert alert-danger">{{$sess->description}}</div>
              @endforeach 
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif
            <form action="{{route('admin.submitBet')}}" method="post">
              @csrf
             
            <div class="row">
            <div class="card col-md-6">
                <div class="card-header">
                  <h3 class="card-title ">To Coin</h3>
                  <div class="card-tools d-flex mt-1">
                        <div class="input-group input-group-sm">
                          <input class="form-control form-control-navbar" type="search" placeholder="Search" id="myInput" onkeyup="myFunction()">
                          <div class="input-group-append">
                            <button class="btn btn-success" type="button">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table class="table" id="myTable">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Price</th>
                      </tr>
                    </thead>
                      <tbody>
                        @if (!empty($coinprices))
                        @foreach ($coinprices as $coin=>$price)
                        <tr>
                          <td>
                            <input type="radio" value="{{$coin}}" name="to_coin" required><span class="pl-3" >{{$coin}}</span>
                          </td>
                          <td class="{{$coin."USDT"}}">
                            ${{$price}}
                          </td>
                        </tr>
                        @endforeach
                              @endif
                            </tbody>
                  </table>
                  </div>
                </div>
              </div>
            <div class="card col-md-6">
                <div class="card-header">
                  <h3 class="card-title ">From Coin</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table class="table">
                      <tbody>
                        @if (!empty($coins))
                        @foreach ($coins as $coin)
                        @if ($coin == "USDT")
                        <tr>
                          <input type="hidden" name="coins[]" value="{{$coin}}">
                          <td>
                            <input type="radio" value="{{$coin}}" name="from_coin" required><span class="pl-3" >{{$coin }}</span>
                          </td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td>
                              {{-- <input type="hidden" name="from_coin" value="USDT"> --}}
                                @foreach ($users as $user)
                                <input type="hidden" value="{{$user}}" name="users[]">
                                @endforeach
                               
                            </td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>
            </div>
           <div class="bottom">
            <div class="form-group mb-1">
              <label>Amount Percentage</label>
              <input type="text" name="per" class="form-control wid-50  per" placeholder="Enter Percentage" value="100" required>
              @error('per')
              <div class="text-danger">{{$message}}</div>
              @enderror
              <div class="error-text text-danger"></div>
            </div>
            <button class="btn btn-primary buy" type="submit" name="type" value="buy">Buy</button>
          </div>
            </form>
            {{-- <div class="card mt-5">
              <div class="card-body">
            <table class="table table-responsive">
              <thead>
                <tr>
                  <td>Bid Id</td>
                  <th>From Coin</th>
                  <th>To Coin</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @if (!empty($bids))
                @foreach ($bids as $bid)
                <tr>
                    <td>{{$bid->id}}</td>
                    <td>{{$bid->from_coin}}</td>
                    <td>{{$bid->to_coin}}</td>
                    <td><a href="{{route('admin.binanceHistory',["id"=>$bid->id,"type"=>"Buy"])}}" class="btn btn-success">View Users</a></td>
                    </tr>
                    @endforeach
                    @endif
                  </tbody>
            </table>
              </div>
            </div> --}}
        </div>
    </section>
</div>
<script>

function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

  $(document).ready(function(){
    $(".per").blur(function(){
      var per = $(this).val();
      $(".buy").prop("disabled",false);
      $(".error-text").text("");
      if(per < 10){
          $(".error-text").text("Percentage must be equal to or greater than 10");
          $(".buy").prop("disabled",true);
      }
    })

  });
</script>
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
          // $("."+symbol).fadeOut(2000);
          // $("."+symbol).fadeIn(2000);
      });
     
  };
  </script>
@endsection