<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Branches;
use App\Products;
use Auth;
use PDF;
use App\UploadFile;
use Session;
use Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $uploaded=UploadFile::where('user_id', Auth::id())->orderBy('id','desc')->first();
        $loaded=$uploaded->poster;
        return view('home', compact('loaded'));
    }

    public function users(){
         if(Auth::user()->is_admin=='1'){
        $users=User::get();
        return view('users', compact('users'));
        }
        else{
            return redirect('home');
        }
    }
 
    public function reports() {
        return view('reports');
    }

    public function delreport(Request $request) {

    $report=UploadFile::where('id', $request->report)->first();
        if(isset($report)){
            $delrep=UploadFile::where('id', $report->id)->delete();
            $delfile=File::delete(public_path('/uploads/').$report->file_name);
            return redirect('reports')->with('success','Your Report Deleted Successfully.');
        }
        else{
             return redirect('reports')->with('warning','Something went wrong.');
        }

    }

    public function edituser(Request $request){
        $user=User::where('id',$request->userid)->first();
        return response()->json(['user'=>$user]);
    }
    public function editbranch(Request $request){
        $branch=Branches::where('id',$request->bid)->first();
        return response()->json(['branch'=>$branch]);
    }

    public function editproduct(Request $request){
        $product=Products::where('id',$request->pid)->first();
        return response()->json(['product'=>$product]);
    }

    public function updateuser(Request $request){
        $isadmin=$request['is_admin'];
        if($isadmin!='1')
            $isadmin=='0';
        $username=$request->username;
        $userid=$request->id;
        $checkusrnme=User::where('username',$username)->where('id',$userid)->get();
        if(isset($checkusrnme) && $checkusrnme->count()>0){
            return redirect('users')->with('warning','Can not update user, Username already exist.');
        }
        else{
        if($request->password!=''){
        $update=User::where('id',$request->userid)->update([
            'name' => $request['name'],
            'username' => $request['username'],
            'branchid' => $request['branchid'],
            'is_admin' => $isadmin,
            'password' => Hash::make($request['password']),
        ]);
        }
        else{
            $update=User::where('id',$request->userid)->update([
            'name' => $request['name'],
            'username' => $request['username'],
            'branchid' => $request['branchid'],
            'is_admin' => $isadmin,
        ]);
        }
        if(isset($update))
        return redirect('users')->with('success','User is updated successfully.');
        else
            return redirect('users')->with('warning','Something went wrong');
        }
        
    }

    public function delusr(Request $request){
       $user=$request->userid;
       $delete=User::where('id',$user)->delete();
       if(isset($delete))
       return redirect('users')->with('success','User is deleted successfully');
        else
            return redirect('users')->with('warning','Sorry, Something went wrong.');
    }

    public function newuser(Request $data)
    {
        $isadmin=$data['is_admin'];
        if($isadmin!='1')
            $isadmin=='0';
        $username=$data->username;
        $checkusrnme=User::where('username',$username)->get();
        if(isset($checkusrnme) && $checkusrnme->count()>0){
            return redirect('users')->with('warning','Username already exist, please choose another username');
        }
        else{
        $create=User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'is_admin' => $isadmin,
            'branchid' => $data['branchid'],
            'password' => Hash::make($data['password']),
        ]);
        if(isset($create))
        return redirect('users')->with('success','User is created successfully.');
        else
            return redirect('users')->with('warning','Something went wrong');
        }
    }


    public function readfile(Request $request){

        $time1=strtotime($request->date1);
        $time2=strtotime($request->date2);

        if(isset($request->branchid))
        $branchid=$request->branchid;
        else
        $branchid=Auth::user()->branchid;
        $saledst=$request->sale;
        if($request->reportid)
        $uploaded=UploadFile::where('id',$request->reportid)->first();
        else
        $uploaded=UploadFile::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        

        $branche=Branches::where('bid',$branchid)->first();
        $branch=$branche->bname. ' - ' .$branche->bid;
        $deduction='15';
        if($branche->btype=='restaurant')
            $deduction='20';
          

        if($request->file('file')){


            $request->validate([
            'file' => 'required'
        ]);
        
         $file = file($request->file->getRealPath());

         $originalname=$request->file('file')->getClientOriginalName();

         $alrul=UploadFile::where('poster',$originalname)->first();
         if(isset($alrul) && $alrul->count()>0){
            $delfile=File::delete(public_path('/uploads/').$alrul->file_name);
            $delul=UploadFile::where('id',$alrul->id)->delete();
            
         }

        $csv = array_map('str_getcsv', $file);
        

        $filee            = $request->file('file');
        $identifier      = Auth::id().'-'.time("Ymd");
        

        $destinationPath = public_path() . '/uploads/' ;
        $extension       = $filee->getClientOriginalExtension();
        $filename        = $identifier . "." . $extension;


        $upload_success = $filee->move($destinationPath, $filename);
        $storefile=UploadFile::create(['user_id'=>Auth::id(),'file_name'=>$filename, 'poster' => $filee->getClientOriginalName()]);


        }
        elseif(isset($uploaded) && count($uploaded)>0){
             
          $daten=file(public_path('/uploads/'.$uploaded['file_name']));
          $csv = array_map('str_getcsv', $daten);
         
        }
        else{
            return Redirect::back()->with('warning', 'No File Found');
        }


        foreach ($csv as $key => $value) {
            if($key=='0'){
                continue;
            }
            else{
                $createon=$value[5];
                $created=date('Y-m-d',strtotime($createon));
                $newcreate=strtotime($created);
                $eachpros=explode( ',', $value[19]);
                foreach($eachpros as $eachpr){
                    $eachpro=ltrim($eachpr);
                    $seperating =substr($eachpro, 0, 2);
                    $quantity = str_replace(' ', '', $seperating);
                    $productname=substr($eachpro, 2, 50);
                    $productrecord=Products::where('name',$productname)->first();
                    if(isset($productrecord))
                    $productprice=$productrecord->price;
                    else
                    $productprice='0';
                    $totalprice=$productprice * $quantity;
                    $procatagory='';
                    if(isset($productrecord))
                    $procatagory=$productrecord->catagory;

                $record= array(
                  "bname" => $value[0],
                  "bid" => $value[3],
                  "pname" => $productname,
                  "uprice" => $productprice,
                  "quantity" => $quantity,
                  "tprice" => $totalprice,
                  "catagory" => $procatagory,
                  'created' => $newcreate
                );
                
                }
            }
            if(isset($record['bid']) && $record['bid']==$request->branchid){
                if(isset($time1) && isset($time2) && $time2 >= $time1){
                if($record['created'] >= $time1 && $record['created'] <= $time2){
                    if($time1!=false){
                        $data[]=$record;
                    }
                
                }
                elseif($request->date1==null && $request->date2==null){
                    $data[]=$record;
                }
                }
                
            }
            elseif(isset($request->reportid)){
                $data[]=$record;
            }

        }


        if(isset($data) && count($data)>0){

        $getunique=unique_array($data);
        foreach ($getunique as $uniquepro) {
            $doarray=explode(',',$uniquepro['quantity']);
            $tquantity=array_sum($doarray);
            $procatagory=$uniquepro['catagory'];
            if(isset($saledst) && $saledst>0){
            $unitdp=$uniquepro['uprice']*$saledst/100;
            $unitdprice=$uniquepro['uprice']-$unitdp;
            }
            else{
                $unitdprice=$uniquepro['uprice'];
                $saledst='0';
            }



            $tprice=$tquantity * $unitdprice;

            $finaldata=array(
                "branch" => $branche->bid,
                "product" => $uniquepro['pname'],
                "quantity" => $tquantity,
                "uprice" => $unitdprice,
                "discount" => $saledst,
                "catagory" => $procatagory,
                "tprice" => $tprice,
            );
            $finally[]=$finaldata;
        }
            


        $proall=Products::get()->toArray();
         $catagorises=cat_array($finally);
         foreach($catagorises as $catagory){
            
            $catarray=array(
                "catagory" => $catagory['catagory'],
                "products" => $catagory['product'],
                "uprice" => $catagory['uprice'],
                "quantity" => $catagory['quantity'],
                "discount" => $catagory['discount'],
                "tprice" => $catagory['tprice']
            );

            $catgroup[]=$catarray;
         }


         

        $revarrys=revenue_array($finally);
        foreach ($revarrys as $revarray){

            $rarray=explode(',',$revarray['tprice']);
            $totalrevenue=array_sum($rarray);
            $dedvalue=$totalrevenue*$deduction/100;
            $totalprofit= $totalrevenue - $dedvalue;

            $revstream=array(
                "revenue" => $totalrevenue,
                "deduction" => $deduction,
                "profit" => $totalprofit,
            );
        }



        if(isset($request->date1) && isset($request->date2)){
            $timee['time1']=$request->date1;
            $timee['time2'] = $request->date2;
            Session::put('Time', $timee);
        }


        Session::put('Data', $data);
        Session::put('Finally', $finally);
        Session::put('Revenue', $revstream);

        $html = view('recentadded', compact('data','branch','deduction','finally','revstream','timee','catgroup'))->render();

        if(isset($storefile))
            $loaded=$storefile->poster;
        else
        $loaded=$uploaded->poster;

        return view('home',compact('html','nodata','loaded'));
    }
    else{
        if(isset($storefile))
            $loaded=$storefile->poster;
        else
        $loaded=$uploaded->poster;
        $nodata='No Data Found!';
        return view('home', compact('nodata', 'loaded'));
    }
        

    }

    public function branches(){
        $branches=Branches::get();
        return view('branches',compact('branches'));
    }
    public function newbranch(Request $request){
        $checkid=Branches::where('bid',$request->bid)->get();
        if(isset($checkid) && $checkid->count()>0){
            return redirect('branches')->with('warning','Branch ID already exist.');
        }
        else{
            $create=Branches::create([
            'bid' => $request['bid'],
            'bname' => $request['bname'],
            'btype' => $request['branch_type'],
            'baddress' => $request['baddress'],
        ]);
            if(isset($create))
                return redirect('branches')->with('success','New Branch created successfully.');
            else
                return redirect('branches')->with('warning','Something went wrong.');
        }
    }


    public function updatebranch(Request $request){
        $checkid=Branches::where('bid',$request->branch)->where('id','!=',$request->tabid)->get();
        if($request->branch==$request->bid){
            $update=Branches::where('bid',$request->branch)->update(['bname' => $request->bname,'btype' => $request->branch_type,'baddress' => $request->baddress]);
            if(isset($update))
                return redirect('branches')->with('success','Branch updated successfully.');
            else
                return redirect('branches')->with('warning','Something went wrong.');
        }
        elseif(isset($checkid) && $checkid->count()>0){
            return redirect('branches')->with('warning','Branch ID already exist.');
        }
        else{
            $update=Branches::where('bid',$request->branch)->update(['bid' => $request->bid,'bname' => $request->bname,'btype' => $request->branch_type,'baddress' => $request->baddress]);
            if(isset($update))
                return redirect('branches')->with('success','Branch updated successfully.');
            else
                return redirect('branches')->with('warning','Something went wrong.');
        }
    }



     public function updateproduct(Request $request){
        
        
            $update=Products::where('id',$request->productid)->update(['name' => $request->pname,'catagory' => $request->pcatagory,'price' => $request->pprice]);
            if(isset($update))
                return redirect('products/'.$request->bid)->with('success','Product updated successfully.');
            else
                return redirect('products/'.$request->bid)->with('warning','Something went wrong.');
    }


    public function managebranch(Request $request){

        $branch=Branches::where('id',$request->branch)->first();
        $products=Products::where('branch_id',$branch->bid)->get();
        return view('productview', compact('branch','products'));
    }

    public function getpros($branchid){

        $branch=Branches::where('bid',$branchid)->first();
        $products=Products::where('branch_id',$branch->bid)->get();
        return view('productview', compact('branch','products'));
    }


    public function newproduct(Request $request){
        $create=Products::create([
            'branch_id' => $request->bid,
            'name' => $request->pname,
            'catagory' => $request->catagory,
            'price' => $request->pprice
        ]);
        if(isset($create))
            return redirect('products/'.$request->bid)->with('success','New Product created successfully in '.$request->bid.'.');
        else
            return redirect('branches')->with('warning','Something went wrong.');
    }
    public function delproduct(Request $request){
        $product=$request->product;
       $delete=Products::where('id',$product)->delete();
       if(isset($delete))
       return redirect('branches')->with('success','Product Deleted Successfully');
        else
            return redirect('users')->with('warning','Sorry, Something went wrong.');
    }

    public function pdfview(){
        $mytime = Carbon\Carbon::now();
        $today= $mytime->toDateString();
       $data=Session::get('Data');
       $finally=Session::get('Finally');
        $revstream=Session::get('Revenue');
        $timee=Session::get('Time');
       $filename='report-'.$today.'.pdf';
       $loading['data']=$data;
       $loading['finally']=$finally;
       $loading['revstream']=$revstream;
       $loading['timee'] = $timee;
        Session::put('Time', '');
        $pdf = \PDF::loadView('pdf',['loading'=>$loading]);  
        return $pdf->download($filename);
    }

}
