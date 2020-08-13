<div class="modal fade" id="EditProduct" aria-hidden="true" aria-labelledby="addUserForm"
      role="dialog" tabindex="-1">
      <div class="modal-dialog modal-simple">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h4 class="modal-title">Edit Product</h4>
          </div>
          <form method="post" action="{{ url('updateproduct') }}">
                @csrf
                <input type="hidden" name="productid" id="BRANCKIDp">
          <div class="modal-body">
              
              <div class="form-group">
                <input type="hidden" name="bid" id="UpdateBranch" value="">
                <label>Branch ID</label><br>
                  <span class="BranchGEt" style="font-size: 30px;"></span>
              </div>
              <div class="form-group">
                <label>Change Product Name</label>
                <input type="text" class="form-control" id="UpdatePname" required="" name="pname" placeholder="Product Name" />
              </div>
              <div class="form-group">
                <label>Change Product Catagory</label><br>
                <select style="width: 400px;height: 40px" name="pcatagory">
                  <option id="ProductType" value="">Select</option>
                  <option value="Hopia">Hopia</option>
                  <option value="Chinese Deli">Chinese Deli</option>
                </select>
              </div>
              <div class="form-group">
                <label>Product Price</label>
                <input type="text" class="form-control" id="UpdatePprice" required="" name="pprice" placeholder="Product Price" />
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
      function editproduct(product) {
     $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

       jQuery.ajax({
    url: "{{ url('editproduct') }}",
    type: 'POST',
    data: {
       pid: product,
    },
    success: function(result){ 
      console.log(result);
      $('#EditProduct').modal('show');
      $('#EditProduct').find('#BRANCKIDp').val(result.product.id)
      $('#EditProduct').find('#UpdateBranch').val(result.product.branch_id)
      $('#EditProduct').find('.BranchGEt').text(result.product.branch_id)
      $('#EditProduct').find('#UpdatePname').val(result.product.name)
      $('#EditProduct').find('#UpdatePprice').val(result.product.price)
      $('#EditProduct').find('#ProductType').val(result.product.catagory)
      $('#EditProduct').find('#ProductType').text(result.product.catagory)
    }});
  }
    </script>