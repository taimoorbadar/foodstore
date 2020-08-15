@extends('layouts.app')

@section('content')

@php
use App\UploadFile;

$reports=UploadFile::where('user_id',Auth::id())->orderBy('id','desc')->get();
@endphp
<style type="text/css">
.alert{
  width: 100%!important;
}  
</style>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

              
                <div class="row">
                    <h3 style="width: 100%;text-align: center;">Reports Uploaded</h3>
                   <!--  <a href="#" style="position: absolute;right: 30px;top: 17px;padding: 5px 20px;background: #4e4e88;color: white;" onclick="CreateNew()">New User</a> -->
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                      
                                <span>{!! \Session::get('success') !!}</span>
                        </div>
                    @endif
                    @if (\Session::has('warning'))
                        <div class="alert alert-danger">
                                <span>{!! \Session::get('warning') !!}</span>
                        </div>
                    @endif
                            <table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr"
                    data-selectable="selectable">
                    <thead>
                      <tr>
                       
                        <th scope="col">User Name</th>
                        <th scope="col">Report Name</th>
                        <th scope="col">Added on</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(isset($reports) && $reports->count()>0)
                      @foreach($reports as $report)
                    
                      <tr >
                       
                        <td>
                          {{Auth::user()->name}}
                        </td>
                        <td >{{$report->poster}}</td>
                        <td >{{$report->created_at}}</td>
                        <td style="display: flex;">
                          <a style="margin-top: 5px" href="#" onclick="editrepo({{$report->id}})"><input type="hidden" name="reportid" value="{{$report->id}}"> Edit</a>
                          <form method="post" action="{{ url('delreport') }}">
                            @csrf
                            <input type="hidden" name="report" value="{{$report->id}}" class="reportid">
                             <button style="margin-left: 10px; background: red;border:none" class="btn btn-primary" type="submit">Delete</button>
                          </form>

                          <form method="post" action="{{ url('readfile') }}">
                            @csrf
                            <input type="hidden" name="reportid" value="{{$report->id}}" class="reportid">
                             <button style="margin-left: 10px; background: green;border:none" class="btn btn-primary" type="submit">View</button>
                          </form>
                          
                          </td>
                        <td class="suf-cell"></td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
                
            </div>

        </div>
    </div>
</div>


 <div class="modal fade" id="ReportFrom" aria-hidden="true" aria-labelledby="ReportFrom"
      role="dialog" tabindex="-1">
      <div class="modal-dialog modal-simple">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h4 class="modal-title">Change Report Name</h4>
          </div>
          <form method="post" action="{{ url('updaterepo') }}">
                @csrf
          <div class="modal-body">
              <div class="form-group">
                <label>Change Report Name</label>
                <input type="hidden" id="RepoID" name="repoid" >
                <input type="text" id="RepoName" class="form-control" required="" name="name" placeholder="Name" />
              </div>
              
              
              
          </div>
          <div class="modal-footer">
            <a class="btn btn-sm btn-white" data-dismiss="modal" href="javascript:void(0)">Cancel</a>
            <button class="btn btn-primary" type="submit">Update</button>
          </div>
          </form>
        </div>
      </div>
    </div>
<script >
  function editrepo(report) {
     $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

       jQuery.ajax({
    url: "{{ url('editrepo') }}",
    type: 'POST',
    data: {
       report: report,
    },
    success: function(result){ 
      $('#ReportFrom').modal('show');
      $('#ReportFrom').find('#RepoID').val(result.report.id)
      $('#ReportFrom').find('#RepoName').val(result.report.file_name)
      
    }});
  }
</script>


@endsection