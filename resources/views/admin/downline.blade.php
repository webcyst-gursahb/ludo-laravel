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
                  <h3 class="card-title mb-1">All Downlines</h3>
                    <div class="card-tools d-flex mt-1">
                        <form class="form-inline ml-3" action="" method="get">
                            <div class="input-group input-group-sm">
                              <input class="form-control form-control-navbar" type="search" placeholder="Search By User id" name="user_id">
                              <div class="input-group-append">
                                <button class="btn btn-success" type="submit">
                                  <i class="fas fa-search"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                        <form class="form-inline ml-3" action="" method="get">
                            <div class="input-group input-group-sm">
                              <input class="form-control form-control-navbar" type="search" placeholder="Search by Tag Sponser" name="tagsp">
                              <div class="input-group-append">
                                <button class="btn btn-success" type="submit">
                                  <i class="fas fa-search"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0" style="overflow: hidden;">
                  <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th >#</th>
                        <th>User UID</th>
                        <th>Tag Sponser UID</th>
                        <th>Level</th>
                        {{-- <th>Rank</th> --}}
                        <th> Level</th>
                        <th> Activation Date</th>
                        <th>Package Active</th>
                        <th style="min-width: 120px;">Date</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($sponsers))
                        @foreach ($sponsers as $key=>$sp)
                        <tr>
                            <td>{{$sponsers->firstItem()+$key}}</td>
                            <td>{{$sp->user_id}}</td>
                            <td>{{$sp->tagsp}}</td>
                            <td>{{$sp->level}}</td>
                            {{-- <td>{{$sp->rank}}</td> --}}
                            <td>{{$sp->rank_level}}</td>
                            <td>{{$sp->activation_date}}</td>
                            <td>{{$sp->rank_level > 0 ? "Yes":"No"}}</td>
                            <td>{{$sp->created_at}}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                  </table>
                  </div>
                  {{$sponsers->links()}}
                </div>
              </div>
        </div>
    </section>
</div>
@endsection