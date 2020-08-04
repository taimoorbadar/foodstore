@extends('layouts.app')

@section('content')
@php
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
                    <div style="width: 100%;margin: 0 35%;">
                    <form action="{{url('readfile')}}" enctype="multipart/form-data" method="POST" class="dropzone" style="border:2px dashed blue;padding: 0">
                      @csrf
                    <div class="fallback">
                      <input name="file" type="file" multiple / style="padding: 60px 20px;">
                      @if(Auth::user()->is_admin=='1')
                      <div style="position: absolute;margin-top: 20px;">
                      <label>Select Branch</label>
                      <select name="branchid" style="width: 100px;height: 35px;">
                        @if(isset($branchess) && $branchess->count()>0)
                        @foreach($branchess as $branche)
                        <option value="{{$branche->bid}}">{{$branche->bname}} - {{$branche->bid}}</option>
                        @endforeach
                        @endif
                      </select>
                      </div>
                      @else
                      <input type="hidden" name="branchid" value="{{Auth::user()->branchid}}">
                      @endif
                      <button type="submit" style="padding: 5px 40px;float: right;background: #61bfae;border: 1px solid #61bfae;color: white;margin-top: 20px;border-radius: 5px;">Load</button>
                    </div>
                  </form>
                    </div>

                </div>
                @if(isset($html))
                {!!$html!!}
                @endif
            </div>

        </div>
    </div>
</div>

@endsection
