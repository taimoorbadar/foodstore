@extends('layouts.app')

@section('content')
@php
if(isset($uploaded)){
$loaded=$uploaded->poster;
}
use App\Branches;

$branchess=Branches::get();
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

		<div class="row">
	@if (\Session::has('alert'))
                        <div class="alert alert-danger">
                                <span>{!! \Session::get('alert') !!}</span>
                        </div>
                    @endif
                    <h3 style="width: 100%;text-align: center;">Select or Drag Order Report CSV file</h3>
                    <div style="width: 100%;margin: 0 25%;">
                    <form action="{{url('readfile')}}" enctype="multipart/form-data" method="POST" class="dropzone" style="border:2px dashed blue;padding: 0">
                      @csrf
                    <div class="fallback">
                      <input name="file" type="file" multiple / style="padding: 60px 20px;" id="file" accept=".csv">
                      @if(isset($loaded))
                      <div class="already-loaded" style="    position: absolute;margin-top: -47px;">
                       <p style="font-size: 15px;color: #ca7488;margin-left: 5px;font-weight: 900;"> Loaded Report<br> <span style="color: black; font-size: 13px">{{$loaded}}</span></p>
                      </div>
                      @endif
                      <div class="filter-by-date" style="position: absolute;margin-top: 115px;">
                        <label>Filter by Date (optional)</label>
                        <div style="display: flex;">
                        <input type="date" name="date1" style="margin-right: 10px;height: 35px;">
                        <input type="date" name="date2" style="height: 35px">
                        </div>
                        <hr style="color: gray">
                      </div>
                      <div class="sale-discount" style="position: absolute;margin-top:20px">
                        <label>Select Branch</label>
                      <select name="branchid" style="width: 100%;height: 35px;border:1px solid gray">
                        @if(isset($branchess) && $branchess->count()>0)
                        @foreach($branchess as $branche)
                        <option value="{{$branche->bid}}">{{$branche->bname}} - {{$branche->bid}}</option>
                        @endforeach
                        @endif
                      </select><hr style="color: gray">
                        
	
                      </div>
                      @if(Auth::user()->is_admin=='1')
                      <div style="position: absolute;margin-top: 205px;">
                      <label>Sale Discount</label>
                        <input type="number" name="sale" style="border:1px solid gray; height: 35px" placeholder="optional">
                        <label>%</label>
                      </div>
                      @else
                      <input type="hidden" name="branchid" value="{{Auth::user()->branchid}}">
                      @endif
                      <button type="submit" style="padding: 5px 40px;float: right;background: #61bfae;border: 1px solid #61bfae;color: white;margin-top: 205px;border-radius: 5px;">Load</button>
                    </div>
                  </form>
                    </div>

                </div>
                @if(isset($nodata))
                <div class="no-data" style="text-align: center;margin-top: 70px;">
                  <h3>No data found from this interval!</h3>
                </div>
                @endif
                @if(isset($html))
                {!!$html!!}
                @endif
            </div>

        </div>
    </div>
</div>

<script>
  $("#file").change(function(){
         $('body').find('.already-loaded').css('display','none');
 });
</script>

@endsection

