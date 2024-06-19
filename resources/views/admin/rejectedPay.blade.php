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
                  <h3 class="card-title ">Rejected Payments</h3>
                  <div class="card-tools d-flex mt-1">
                    {{-- <form class="form-inline ml-3" action="" method="get">
                        <div class="input-group input-group-sm">
                          <input class="form-control form-control-navbar" type="search" placeholder="Search"  name="search">
                          <div class="input-group-append">
                            <button class="btn btn-success" type="submit">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </form> --}}
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table ">
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
                        <th>Status</th>
                        <th>Remarks</th>
                        <th style="min-width: 120px;">Date</th>
                        
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
                            <td>Rejected</td>
                            <td>{{$payment->review}}</td>
                            <td>{{$payment->created_at}}</td>
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

<div id="imgModal" class="modal imgModal">

  <span class="close cls mt-5">&times;</span>

  <img class="modal-content img-content" id="img01">

</div>
<script>
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