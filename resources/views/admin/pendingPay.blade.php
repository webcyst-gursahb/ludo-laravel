@extends('layouts.admin_app')
   
@section('content')
<style>
  /* Style the Image Used to Trigger the Modal */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.imgModal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.img-content {
  margin: auto;
  display: block;
  width: 20%;
  max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
  margin: auto;
  display: block;
  width: 20%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation - Zoom in the Modal */
.img-content, #caption {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .img-content {
    width: 100%;
  }
}
</style>
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
                  <h3 class="card-title ">Pending Requests</h3>
                  
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
                        <th>User SPID</th>
                        <th>SP Name</th>
                        <th>Amount</th>
                        <th>Transaction Id</th>
                        <th>Slip</th>
                        {{-- <th>Wallet Type</th> --}}
                        <th style="min-width: 120px;">Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (!empty($pays))
                        @foreach ($pays as $key=>$payment)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$payment->user_name}}</td>
                            <td>{{$payment->user->uid}}</td>
                            <td>{{$payment->user->spid}}</td>
                            <td>{{$payment->sponser->name}}</td>
                            <td>{{$payment->amount}}</td>
                            <td>{{$payment->transaction_id}}</td>
                            <td><img src="{{asset('transaction_slips/'.$payment->screen_shot)}}" alt="" width="30" id="myImg" onclick="imgZoom('{{asset('transaction_slips/'.$payment->screen_shot)}}')"></td>
                            {{-- <td>{{$with->wallet_type=="F"?"Fuel":"Main"}}</td> --}}
                            <td>{{$payment->created_at}}</td>

                            <td style="display: -webkit-inline-box;" >
                              <form action="{{route('admin.accept')}}" method="POST" class="acceptForm">
                                @csrf
                                <input type="hidden" name="id" value="{{$payment->id}}" class="id">
                                <input type="hidden" name="user_id" value="{{$payment->user_id}}" class="id">
                                <input type="hidden" name="trans_id" value="{{$payment->transaction_id}}" class="trans">
                                <input type="hidden" name="amount" value="{{$payment->amount}}" class="amnt">
                                <button type="submit" class="btn btn-success btn-sm mr-2" onclick="return confirm('Are You Sure Want To Accept')">Accept</button>
                              </form>
                                {{-- <button type="buttton" class="btn btn-success btn-sm mr-2" onclick="Accept()">Accept</button> --}}
                                <button type="button" class="btn btn-danger btn-sm mr-2 reject" onclick="Reject({{$payment->id}})" >Reject</button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                  </table>
                  {{$pays->links()}}
                  </div>
                </div>
              </div>
        </div>
    </section>
</div>
{{-- accept request modal --}}
<div class="modal fade request" id="acceptModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content ">
      <div class="modal-header">
        <h4 class="modal-title">Accept Request</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="{{route('admin.accept')}}" method="post">
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
      <div class="modal-body">
        <form action="{{route('admin.reject')}}" method="POST">
          @csrf
        <input type="hidden"  name="id" class="user_id" >
        {{-- <input type="hidden"  name="amount" class="amount" >
        <input type="hidden"  name="trans_id" class="trans_id" > --}}
        <div class="form-group">
          <label>Review</label>
          <textarea name="review" rows="3" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-default" name="reject">Reject</button>
      </form>
      </div>
      
    </div>
  </div>
</div>


<div id="imgModal" class="modal imgModal">

  <span class="close cls mt-5">&times;</span>

  <img class="modal-content img-content" id="img01">

</div>

<script>
  function Accept(){
     if(confirm('Are You Sure Want To Accept')){
        $(".acceptForm").submit();
     }
    // $(document).ready(function(){
    //   $("#acceptModal").modal("show");
    //   $(".acc_id").val(id);
    // });
  }
  function Reject(id){
    // var id =  $(this).attr('data-id');
    // var amount =  $(this).attr('data-amount');
    // var trans_id =  $('.trans').val();
    $("#rejectModal").modal("show");
    
      $(".user_id").val(id);
      // $(".amount").val(amount);
      // $(".trans_id").val(trans_id);
  }

  $('.cls').click(function(){
    $("#imgModal").css("display","none");
  });


  // Get the modal
var modal = document.getElementById("imgModal");



// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");

function imgZoom(src){
  
  modal.style.display = "block";
  modalImg.src = src;
  captionText.innerHTML = this.alt;
}
// img.onclick = function(){
// }

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
</script>
@endsection