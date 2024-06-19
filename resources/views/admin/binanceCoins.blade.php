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
          
            @if (session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif
             
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title ">Binance Coins</h3>
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
                        <th>Name</th>
                        <th>Value</th>
                      </tr>
                    </thead>
                      <tbody>
                        @if (!empty($coins))
                        @foreach ($coins as $coin)
                        <tr>
                          <td>{{$coin->coin_name}}</td>
                          <td>{{$coin->value}}</td>
                          <td><a href="{{route('binance.editCoin',$coin->id)}}" class="btn btn-warning btn-sm">Edit</a></td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                  </table>
                  </div>
                </div>
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
</script>

@endsection