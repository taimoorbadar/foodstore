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
                    <h3 style="width: 100%;text-align: center;">All Products from {{$branch->bname}}</h3>
                    <a href="#" style="position: absolute;right: 0;top: 17px;padding: 5px 20px;background: #4e4e88;color: white;" onclick="CreateNewProduct()">Add Product</a>
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
                        
                        <th scope="col">ID</th>
                        <th scope="col">Branch ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(isset($products) && $products->count()>0)
                      @foreach($products as $product)
                      <tr >
                        <td class="pre-cell"></td>
                        
                        <td>
                          {{$product->id}}
                        </td>
                        <td >{{$product->branch_id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->price}}</td>
                        <td style="display: flex;">
                          <form method="post" action="{{ url('delproduct') }}">
                            @csrf
                            <input type="hidden" name="product" value="{{$product->id}}" class="userid">
                             <button style="margin-left: 10px; background: red;border:none" class="btn btn-primary" type="submit">Delete</button>
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
    <div class="modal fade" id="addProductForm" aria-hidden="true" aria-labelledby="addUserForm"
      role="dialog" tabindex="-1">
      <div class="modal-dialog modal-simple">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h4 class="modal-title">Create New Product</h4>
          </div>
          <form method="post" action="{{ url('newproduct') }}">
                @csrf
          <div class="modal-body">
              <div class="form-group">
                <input type="hidden" name="bid" value="{{$branch->bid}}">
                <label>Branch ID</label><br>
                  <span style="font-size: 30px;">{{$branch->bid}}</span>
              </div>
              <div class="form-group">
                <label>Product Name</label>
                <input type="text" class="form-control" required="" name="pname" placeholder="Product Name" />
              </div>
              <div class="form-group">
                <label>Product Price</label>
                <input type="text" class="form-control" name="pprice" placeholder="Product Price" />
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

function CreateNewProduct(){
  $('#addProductForm').modal('show');
}

</script>

@endsection