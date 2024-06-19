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
                  <h3 class="card-title ">Binance Balance</h3>
                  <div class="card-tools">
                      <div>User Name: <span>{{$user->name}}</span></div>
                      <div>User Email: <span>{{$user->email}}</span></div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Currency</th>
                        {{-- <th>User Name</th>
                        <th>User Email</th> --}}
                        <th>Balance</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($coins))
                        @foreach ($coins as $coin=>$bal)
                        <tr>
                            <td>{{$coin}}</td>
                            {{-- <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td> --}}
                            <td>{{$bal}}</td>
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
@endsection