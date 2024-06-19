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
                  <h4 class="card-title">Update Api</h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="card-body">
                        <form role="form" method="post" action="{{route('admin.storeApi')}}" enctype="multipart/form-data">
                        @csrf
                          <div class="col-md-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Video Url</label>
                                <input type="text" class="form-control" placeholder="Enter  Video Url" name="video"  value="{{$video ? $video->value:''}}" >
                              </div>
                              <div class="form-group">
                                <label>YouTube Url</label>
                                <input type="text" class="form-control" placeholder="Enter YouTube Video Url" name="youtube"  value="{{$youtube?$youtube->value:''}}" >
                              </div>
                              <div class="form-group">
                                <label>Whatsapp Url</label>
                                <input type="text" class="form-control" placeholder="Enter whatsapp Url" name="whatsapp"  value="{{$whatsapp?$whatsapp->value:''}} " >
                              </div>
                              <div class="form-group">
                                <label>Telegram Url</label>
                                <input type="text" class="form-control" placeholder="Enter telegram Url" name="telegram"  value="{{$telegram?$telegram->value:''}}" >
                              </div>
                              <div class="form-group">
                                <label>Zoom Url</label>
                                <input type="text" class="form-control" placeholder="Enter zoom Url" name="zoom"  value="{{$zoom?$zoom->value:''}}" >
                              </div>
                              <div class="form-group">
                                <label>Zoom Start Time</label>
                                <input type="text" class="form-control" placeholder="Enter zoom start time" name="zoom_start"  value="{{$zoom_start?$zoom_start->value:''}}" >
                              </div>
                              <div class="form-group">
                                <label>Instargram Url</label>
                                <input type="text" class="form-control" placeholder="Enter Intagram Url" name="insta"  value="{{$insta?$insta->value:''}}" >
                              </div>
                              <div class="form-group">
                                <label>UPI ID</label>
                                <input type="text" class="form-control" placeholder="Enter UPI Id" name="upi_id"  value="{{$upi_id?$upi_id->value:''}}" >
                              </div>
                              <div class="form-group">
                                <label>Slider Image 1</label>
                                <input type="file" class="form-control"  name="banner"   >
                                  @if (!empty($banner))
                                    <img src="{{asset('slider/'.$banner->value)}}" alt="" width="100">
                                @endif
                              </div>
                              <div class="form-group">
                                <label>Slider Image 2</label>
                                <input type="file" class="form-control"  name="banner1"   >
                                  @if (!empty($banner1))
                                    <img src="{{asset('slider/'.$banner1->value)}}" alt="" width="100">
                                @endif
                              </div>
                              <div class="form-group">
                                <label>Slider Image 3</label>
                                <input type="file" class="form-control"  name="banner2"   >
                                  @if (!empty($banner2))
                                    <img src="{{asset('slider/'.$banner2->value)}}" alt="" width="100">
                                @endif
                              </div>
                              {{-- <div class="form-group">
                                <label>Secret Key</label>
                                <input type="text" class="form-control" placeholder="Enter Secret Key" name="secret_key" value="{{$user->secret_key}}" required>
                              </div>
                              <div class="form-group">
                                <label>Private Key</label>
                                <input type="text" class="form-control" placeholder="Enter Private Key" name="private_key" value="{{$user->private_key}}" required>
                              </div>
                              <div class="form-group">
                                <label>Public Key</label>
                                <input type="text" class="form-control" placeholder="Enter Public Key" name="public_key" value="{{$user->public_key}}" required>
                              </div> --}}
                        <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                      </div>
                </div>
              </div>
        </div>
    </section>
</div>
@endsection