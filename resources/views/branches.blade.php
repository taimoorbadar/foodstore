@extends('layouts.app')

@section('content')
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
                    <h3 style="width: 100%;text-align: center;">All Branches</h3>
                    <a href="#" style="position: absolute;right: 30px;top: 17px;padding: 5px 20px;background: #4e4e88;color: white;" onclick="CreateNewbranch()">New Branch</a>
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
                        <th></th>
                        <th scope="col">
                          <span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
                            <input type="checkbox" class="contacts-checkbox selectable-all" id="select_all"
                            />
                            <label for="select_all"></label>
                          </span>
                        </th>
                        <th scope="col">Branch</th>
                        <th scope="col">Address</th>
                        <th scope="col">action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(isset($branches) && $branches->count()>0)
                      @foreach($branches as $branch)
                      <tr >
                        <td class="pre-cell"></td>
                        <td class="cell-30">
                          <span class="checkbox-custom checkbox-primary checkbox-lg">
                            <input type="checkbox" class="contacts-checkbox selectable-item user_profile" id="list_1" value="{{ $branch->id }}"
                            />
                            <label for="list_1"></label>
                          </span>
                        </td>
                        <td>
                          {{$branch->bid}} - {{$branch->bname}}
                        </td>
                        <td>{{$branch->baddress}}</td>
                        <td style="display: flex;"><a style="margin-top: 5px" href="#" onclick="editbranch({{$branch->id}})"><input type="hidden" name="campid" value="{{$branch->id}}"> Edit</a>
                          <form method="post" action="{{ url('branchdetail') }}">
                            @csrf
                            <input type="hidden" name="branch" value="{{$branch->id}}" class="userid">
                             <button style="margin-left: 10px; background: green;border:none" class="btn btn-primary" type="submit">Products</button>
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


<!-- Add User Form -->
    <div class="modal fade" id="addBranchForm" aria-hidden="true" aria-labelledby="addUserForm"
      role="dialog" tabindex="-1">
      <div class="modal-dialog modal-simple">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h4 class="modal-title">Create New User</h4>
          </div>
          <form method="post" action="{{ url('newbranch') }}">
                @csrf
          <div class="modal-body">
              <div class="form-group">
                <label>Branch ID</label>
                <input type="text" class="form-control" required="" name="bid" placeholder="Branch ID" />
              </div>
              <div class="form-group">
                <label>Branch Name</label>
                <input type="text" class="form-control" required="" name="bname" placeholder="Branch Name" />
              </div>
              <div class="form-group">
                <label>Branch Address</label>
                <input type="text" class="form-control" name="baddress" placeholder="Branch Address" />
              </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-sm btn-white" data-dismiss="modal" href="javascript:void(0)">Cancel</a>
            <button class="btn btn-primary" type="submit">Create</button>
          </div>
          </form>
        </div>
      </div>
    </div>
@include('updatebranch')

<script type="text/javascript">

function CreateNewbranch(){
  $('#addBranchForm').modal('show');
}

</script>

@endsection
