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
            <form action="{{route('admin.binanceBet')}}" method="get">
            <div class="card">
                
                <div class="card-header">
                  <h3 class="card-title ">All Binance Users</h3>
                  <div class="card-tools">
                      <button class="btn btn-primary" type="submit">Place Bid</button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>#</th>
                        <th>User UID</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>USDT Balance</th>
                        <th style="min-width: 120px;">Date</th>
                        <th style="min-width:280px"></th>
                      </tr>
                    </thead>
                    
                    <tbody>
                        @if (!empty($users))
                        @foreach ($users as $key=>$user)
                        {{-- @if ($user->balance >= 10 && $user->bal_usdt >9) --}}
                        <tr>
                          
                            <td><input type="checkbox" name="users[]" value="{{$user->id}}" class="checkbox"></td>
                            <td>{{$users->firstItem()+$key}}</td>
                            <td>{{$user->UID}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->bal_usdt}}</td>
                            <td>{{$user->created_at}}</td>
                            <td class="d-flex">
                              <a href="{{route('admin.binanceBal',["id"=>$user->id])}}" class="btn btn-primary mr-2">View Balance</a>
                              <a href="{{route('admin.binanceHistory',["user_id"=>$user->id])}}" class="btn btn-info">View History</a>
                            </td> 
                        </tr>
                        {{-- @endif --}}
                        @endforeach 
                        @endif
                    </tbody>
                </table>
                  </div>
                  {{$users->links()}}
                </div>
              </div>
            </form>
        </div>
    </section>
</div>
<script>
  $('#selectAll').click(function() {
        if ($(this).prop('checked')) {
            $('.checkbox').prop('checked', true);
        } else {
            $('.checkbox').prop('checked', false);
        }
    });
</script>
@endsection