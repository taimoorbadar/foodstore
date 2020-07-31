<div class="row">
  <a id="download_button" href="{{url('pdfview')}}" style="position: absolute;right: 0;margin-top: 35px;color: #550080;font-size: 20px;"> Download as PDF</a>
</div>
<div class="row" id="contnet">
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
                      @if(isset($data) && count($data)>0)
                      @foreach($data as $dat)
                      <tr >
                        <td class="pre-cell"></td>
                        <td>{{$dat['pname']}}</td>
                        <td>{{$dat['uprice']}}</td>
                        <td>{{$dat['quantity']}}</td>
                        <td>{{$dat['tprice']}}</td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
                <div class="row" id="Summary">
                    <h3 style="width: 100%;text-align: center;margin-top: 80px">Summary</h3>
                            <table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr"
                    data-selectable="selectable">
                    <thead>
                      <tr>
                        <th></th>
                        
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
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
                        <td>{{$final['tprice']}}</td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>

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