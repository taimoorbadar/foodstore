<div class="row">
  <a id="Click_Download" onclick="Click_Download()" href="#" style="position: absolute;right: 0;margin-top: 82px;color: #550080;font-size: 20px;"> Download as PDF</a>
</div>
<div class="row" id="Content_Download">
                    <h3 style="width: 100%;text-align: center;margin-top: 80px">Recently Added Data</h3>
                            <table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr"
                    data-selectable="selectable">
                    <thead>
                      <tr>
                        <th></th>
                        
                        <th scope="col">Branch ID</th>
                        <th scope="col">Branch Name</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(isset($data) && count($data)>0)
                      @foreach($data as $dat)
                      <tr >
                        <td class="pre-cell"></td>
                        <td>
                          {{$dat['bid']}}
                        </td>
                        <td >{{$dat['bname']}}</td>
                        <td>{{$dat['pname']}}</td>
                        <td>{{$dat['price']}}</td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>


                <div id="editor"></div>