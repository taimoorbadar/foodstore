<div class="modal fade" id="EditBranch" aria-hidden="true" aria-labelledby="addUserForm"
      role="dialog" tabindex="-1">
      <div class="modal-dialog modal-simple">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h4 class="modal-title">Edit Branch</h4>
          </div>
          <form method="post" action="{{ url('updatebranch') }}">
                @csrf
                <input type="hidden" name="branch" id="BRANCKID">
                <input type="hidden" name="tabid" id="BRANCdID">
          <div class="modal-body">
              <div class="form-group">
                <label>Change Branch ID</label>
                <input type="text" class="form-control" id="UpdateBranch" required="" name="bid" placeholder="Branch ID" />
              </div>
              <div class="form-group">
                <label>Change Branch Name</label>
                <input type="text" class="form-control" id="UpdateBname" required="" name="bname" placeholder="Branch Name" />
              </div>
              <div class="form-group">
                <label>Change Branch Address</label>
                <input type="text" class="form-control" id="BranchAddress" name="baddress" placeholder="Branch Address" />
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
      function editbranch(branch) {
     $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

       jQuery.ajax({
    url: "{{ url('editbranch') }}",
    type: 'POST',
    data: {
       bid: branch,
    },
    success: function(result){ 
      $('#EditBranch').modal('show');
      $('#EditBranch').find('#UpdateBranch').val(result.branch.bid)
      $('#EditBranch').find('#BRANCKID').val(result.branch.bid)
      $('#EditBranch').find('#BRANCdID').val(result.branch.id)
      $('#EditBranch').find('#UpdateBname').val(result.branch.bname)
      $('#EditBranch').find('#BranchAddress').val(result.branch.baddress)
    }});
  }
    </script>