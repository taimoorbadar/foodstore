<div class="row">
  <a id="download_button" href="{{url('pdfview')}}" style="position: absolute;right: 0;margin-top: 35px;color: #550080;font-size: 20px;"> Download as PDF</a>
</div>
<div class="row" id="contnet">
  @if(isset($timee))
  <p style="    margin: 50px 50px 0 50px;">From: <span>{{$timee['time1']}}</span></p>
  <p style="    margin: 50px 50px 0 50px;">To: <span>{{$timee['time2']}}</span></p>
  @endif
                    <h3 style="width: 100%;text-align: center;margin-top: 80px">Data from {{$branch}}</h3>
                            <table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr"
                    data-selectable="selectable">
                    <thead>
                      <tr>
                        <th></th>
                        
                        <th scope="col">Product</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(isset($catgroup) && count($catgroup)>0)
                      @foreach($catgroup as $final)
                      @php

                      $catname=$final['catagory'];
                      $catstyle='';
                      if($final['catagory']==''){
                      
                      $catname='No Catagory';
                      $catstyle='color:red;';
                      }
                      @endphp
                      
                      <tr ><td style="{{$catstyle}}">{{$catname}}</td></tr>
                      @if(isset($data) && count($data)>0)
                      @foreach($data as $key => $dat)
                      @if($dat['catagory']==$final['catagory'])
                      <tr style="border-bottom:1px solid #e6e6e6;">
                        <td class="pre-cell"></td>
                        <td>{{$dat['pname']}}</td>
                        @if($dat['discount']==0)
                        <td>{{$dat['uprice']}}</td>
                        @else
                        <td>{{$dat['oprice']}}({{$dat['discount']}}% Off) = {{$dat['uprice']}}</td>
                        @endif
                        <td>{{$dat['quantity']}}</td>
                        <td>{{$dat['tprice']}}</td>
                      </tr>
                      @endif
                      @endforeach
                      @endif
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>

                <div class="row" id="CatSummary">
                    <h3 style="width: 100%;text-align: center;margin-top: 80px">Summary</h3>
                            <table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr"
                    data-selectable="selectable">
                    <thead>
                      <tr>
                        <th></th>
                        
                        <th scope="col">Products</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Revenue</th>
                        
                      </tr>
                    </thead>
                    
                    <tbody>
                      @if(isset($catgroup) && count($catgroup)>0)
                      @foreach($catgroup as $group)
                      @php
                      $catname=$group['catagory'];
                      $catstyle='';
                      if($group['catagory']==''){
                      
                      $catname='No Catagory';
                      $catstyle='color:red;';
                      }
                      @endphp
                      <tr><td style="{{$catstyle}}">{{$catname}}</td></tr>
                      <tr style="border-bottom: 1px solid #e8e7e7;">
                        <td class="pre-cell"></td>
                        
                        <td>
                          @php
                            
                          $products=$group['products'];
                          $eachpros=explode( ',', $group['products']);
                            
                          @endphp
                        
                        @if(isset($eachpros) && count($eachpros)>0)
                          @foreach($eachpros as $pro)
                          
                          {{$pro}}
                          <br>
                          @endforeach
                          @endif
                     </td>
                     <td>
                          @php
                            
                          $products=$group['quantity'];
                          $eachpros=explode( ',', $group['quantity']);
                            
                          @endphp
                        
                        @if(isset($eachpros) && count($eachpros)>0)
                          @foreach($eachpros as $pro)
                          
                          {{$pro}}
                          <br>
                          @endforeach
                          @endif
                     </td>
                     
                     <td>@php
                            
                          $discount=$group['discount'];
                          $eachpros=explode( ',', $group['discount']);
                            
                          @endphp
                        
                        @if(isset($eachpros) && count($eachpros)>0)
                          @foreach($eachpros as $prod)
                          
                          {{$prod}}%
                          <br>
                          @endforeach
                          @endif</td>
                     <td>
                          @php
                            
                          $products=$group['tprice'];
                          $eachpros=explode( ',', $group['tprice']);
                            
                          @endphp
                        
                        @if(isset($eachpros) && count($eachpros)>0)
                          @foreach($eachpros as $pro)
                          
                          {{$pro}}
                          <br>
                          @endforeach
                          @endif
                     </td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>

               <!--  <div class="row" id="Summary">
                    <h3 style="width: 100%;text-align: center;margin-top: 80px">Summary</h3>
                            <table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr"
                    data-selectable="selectable">
                    <thead>
                      <tr>
                        <th></th>
                        
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Revenue</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(isset($finally) && count($finally)>0)
                      @foreach($finally as $final)
                      <tr >
                        <td class="pre-cell"></td>
                        <td>{{$final['product']}}</td>
                        <td>{{$final['quantity']}}</td>
                        <td>{{$final['discount']}}%</td>
                        <td>{{$final['tprice']}}</td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div> -->

                <div class="row" id="Revenue">
                    <h3 style="width: 100%;text-align: center;margin-top: 80px">Revenue Stream</h3>
                            <table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr"
                    data-selectable="selectable" style="font-size: 23px;">
                    <thead>
                      <tr>
                        <th></th>
                        
                        <th scope="col">Revenue</th>
                        <th scope="col">FoodPanda Deduction</th>
                        <th scope="col">Profit</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(isset($revstream))
                      <tr >
                        <td class="pre-cell"></td>
                        <td>{{$revstream['revenue']}}</td>
                        <td>{{$revstream['deduction']}}%</td>
                        <td>{{$revstream['profit']}}</td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>

                <div id="elementH"></div>


                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script type="text/javascript">

  var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

function Click_Download() {
  var elementHTML = $('#contnet').html();
var specialElementHandlers = {
    '#elementH': function (element, renderer) {
        return true;
    }
};
doc.fromHTML(elementHTML, 15, 15, {
    'width': 170,
    'elementHandlers': specialElementHandlers
});

// Save the PDF
doc.save('sample-document.pdf');

}
</script>