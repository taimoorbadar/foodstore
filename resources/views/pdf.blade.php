<style type="text/css">
  td{
    text-align: center;
  }
</style>
<div class="row" id="contnet">
                    <h2 style="width: 100%;text-align: center;margin-top: 80px">Data Record</h2>
                            <table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr"
                    data-selectable="selectable">
                    <thead>
                      <tr>
                        <th></th>
                        
                        <th scope="col">Branch</th>
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
                          {{$dat['bid']}} - {{$dat['bname']}}
                        </td>
                        <td>{{$dat['pname']}}</td>
                        <td>{{$dat['price']}}</td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>