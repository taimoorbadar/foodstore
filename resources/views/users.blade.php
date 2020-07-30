@extends('layouts.app')

@section('content')

@php
use App\Branches;

$branchess=Branches::get();
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
                    <h3 style="width: 100%;text-align: center;">All Users</h3>
                    <a href="#" style="position: absolute;right: 30px;top: 17px;padding: 5px 20px;background: #4e4e88;color: white;" onclick="CreateNew()">New User</a>
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
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Branch ID</th>
                        <th scope="col">Admin</th>
                        <th scope="col">Username</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(isset($users) && $users->count()>0)
                      @foreach($users as $user)
                      @php
                      $usradmn= 'No';
                      if($user->is_admin=='1')
                      $usradmn='Yes';
                      @endphp
                      <tr >
                        <td class="pre-cell"></td>
                        <td class="cell-30">
                          <span class="checkbox-custom checkbox-primary checkbox-lg">
                            <input type="checkbox" class="contacts-checkbox selectable-item user_profile" id="list_1" value="{{ $user->id }}"
                            />
                            <label for="list_1"></label>
                          </span>
                        </td>
                        <td>
                          {{$user->id}}
                        </td>
                        <td >{{$user->name}}</td>
                        <td>{{$user->branchid}}</td>
                        <td >{{$usradmn}}</td>
                        <td >{{$user->username}}</td>
                        <td style="display: flex;"><a style="margin-top: 5px" href="#" onclick="edituser({{$user->id}})"><input type="hidden" name="campid" value="{{$user->id}}"> Edit</a>
                          @if($user->id!=Auth::id())
                          <form method="post" action="{{ url('delusr') }}">
                            @csrf
                            <input type="hidden" name="userid" value="{{$user->id}}" class="userid">
                             <button style="margin-left: 10px; background: red;border:none" class="btn btn-primary" type="submit">Delete</button>
                          </form>
                          @else
                          <span style="padding: 2px 10px;background: #59bd59;margin-left: 20px;color: white;border-radius: 10px;">You</span>
                          @endif
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
    <div class="modal fade" id="addUserForm" aria-hidden="true" aria-labelledby="addUserForm"
      role="dialog" tabindex="-1">
      <div class="modal-dialog modal-simple">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h4 class="modal-title">Create New User</h4>
          </div>
          <form method="post" action="{{ url('newuser') }}">
                @csrf
          <div class="modal-body">
              <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" required="" name="name" placeholder="Name" />
              </div>
              <div class="form-group">
                <label>Branch ID</label><br>
                      <select name="branchid" style="width: 420px;height: 35px;">
                        <option>Select Branch</option>
                        @if(isset($branchess) && $branchess->count()>0)
                        @foreach($branchess as $branche)
                        <option value="{{$branche->bid}}">{{$branche->bid}}</option>
                        @endforeach
                        @endif
                      </select>
              </div>
              <div class="form-group">
                <label>Admin Permission</label>
                <select class="form-control" name="is_admin" id="inputadmin" placeholder="Type" name="type">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
              </div>
              <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username" />
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="New Password"
                />
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
@include('updateuser')

<script type="text/javascript">

function CreateNew(){
  $('#addUserForm').modal('show');
}

</script>

@endsection
