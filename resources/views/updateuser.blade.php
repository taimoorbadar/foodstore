<div class="modal fade" id="EditCamp" aria-hidden="true" aria-labelledby="addUserForm"
      role="dialog" tabindex="-1">
      <div class="modal-dialog modal-simple">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h4 class="modal-title">Edit User</h4>
          </div>
          <form method="post" action="{{ url('updateuser') }}">
                @csrf
          <div class="modal-body">
              <div class="form-group">
                 <label>Change Name</label>
                <input type="hidden" name="userid" id="USER_ID" value="">
                <input type="text" class="form-control" id="UpdateName" required="" name="name" placeholder="Name" />
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
                <label> Change Admin Permission</label>
                <select class="form-control" id="inputadmin" placeholder="Type" name="is_admin">
                    <option id="SelectType">Select</option>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
              </div>
              <div class="form-group">
                <label>Change Username</label>
                <input type="text" class="form-control" id="UpdateUsername" required="" name="username" placeholder="Username" />
              </div>
              <div class="form-group">
                <label>Change Password (optional)</label>
                <input type="password" class="form-control" id="UpdatePassword" name="password" placeholder="Change Password" />
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


    <script type="text/javascript">
      function edituser(user) {
     $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

       jQuery.ajax({
    url: "{{ url('edituser') }}",
    type: 'POST',
    data: {
       userid: user,
    },
    success: function(result){ 
      $('#EditCamp').modal('show');
      $('#EditCamp').find('#UpdateName').val(result.user.name)
      $('#EditCamp').find('#UpdateBranch').val(result.user.branchid)
      $('#EditCamp').find('#SelectType').val(result.user.is_admin)
      $('#EditCamp').find('#UpdateUsername').val(result.user.username)
       $('#EditCamp').find('#USER_ID').val(result.user.id)
        $('#EditCamp').find('#UpdatePassword').val('')
    }});
  }
    </script>