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
                  <h3 class="card-title ">Withdraw Requests</h3>
                  
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th >#</th>
                        <th>User Name</th>
                        <th>User UID</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Upi Method</th>
                        <th>Wallet Type</th>
                        <th style="min-width: 120px;">Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($withs))
                        @foreach ($withs as $key=>$with)
                        <tr>
                            <td>{{$withs->firstItem()+$key}}</td>
                            <td>{{$with->user_name}}</td>
                            <td>{{$with->user_UID}}</td>
                            <td>{{$with->amount}}</td>
                            <td>{{$with->type}}</td>
                            <td>{{$with->value}}</td>
                            <td>{{$with->wallet_type=="F"?"Chip":"E-Wallet"}}</td>
                            <td>{{$with->created_at}}</td>
                            <td class="d-flex" >
                                <button type="button" class="btn btn-success btn-sm mr-2" onclick="Accept('{{$with->id}}')">Accept</button>
                                <button type="button" class="btn btn-danger btn-sm mr-2" onclick="Reject('{{$with->id}}')">Reject</button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>
        </div>
    </section>
</div>
{{-- accept request modal --}}
<div class="modal fade request" id="acceptModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Accept Request</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="{{route('withdraw.accept')}}" method="post">
        @csrf
      <div class="modal-body">
        <input type="hidden"  name="id" class="acc_id" >
        <div class="form-group">
          <label>Review</label>
          <textarea name="review" rows="3" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" >Accept</button>
      </div>
    </form>
    </div>
  </div>
</div>

{{-- reject request modal --}}
<div class="modal fade request" id="rejectModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Reject Request </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="{{route('withdraw.reject')}}" method="post">
        @csrf
      <div class="modal-body">
        <input type="hidden"  name="id" class="rej_id" >
        <div class="form-group">
          <label>Review</label>
          <textarea name="review" rows="3" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" >Reject</button>
      </div>
    </form>
    </div>
  </div>
</div>
<script>
  function Accept(id){
    $(document).ready(function(){
      $("#acceptModal").modal("show");
      $(".acc_id").val(id);
    });
  }
  function Reject(id){
    $("#rejectModal").modal("show");
      $(".rej_id").val(id);
  }
</script>
@endsection