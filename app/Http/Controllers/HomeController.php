<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Branches;
use App\Products;
use Auth;

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
        return view('home');
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

    public function edituser(Request $request){
        $user=User::where('id',$request->userid)->first();
        return response()->json(['user'=>$user]);
    }
    public function editbranch(Request $request){
        $branch=Branches::where('id',$request->bid)->first();
        return response()->json(['branch'=>$branch]);
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
          $request->validate([
            'file' => 'required'
        ]);
        

        $file = file($request->file->getRealPath());
        $filee=$request->file('file');
        $filename=Auth::id().'-'.time().'-'.str_replace(' ','-',$filee->getClientOriginalName());
        $csv = array_map('str_getcsv', $file);
        foreach ($csv as $key => $value) {
            if($key=='0'){
                continue;
            }
            else{
                $record= array(
                  "bname" => $value[0],
                  "bid" => $value[3],
                  "pname" => $value[19],
                  "price" => $value[17]
                );
            }
            if(isset($record['bid']) && $record['bid']==$request->branchid){
                $data[]=$record;
            }
        }
        $html = view('recentadded', compact('data'))->render();
        return view('home',compact('html'));

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
            $update=Branches::where('bid',$request->branch)->update(['bname' => $request->bname,'baddress' => $request->baddress]);
            if(isset($update))
                return redirect('branches')->with('success','New Branch created successfully.');
            else
                return redirect('branches')->with('warning','Something went wrong.');
        }
        elseif(isset($checkid) && $checkid->count()>0){
            return redirect('branches')->with('warning','Branch ID already exist.');
        }
        else{
            $update=Branches::where('bid',$request->branch)->update(['bid' => $request->bid,'bname' => $request->bname,'baddress' => $request->baddress]);
            if(isset($update))
                return redirect('branches')->with('success','New Branch created successfully.');
            else
                return redirect('branches')->with('warning','Something went wrong.');
        }
    }


    public function managebranch(Request $request){

        $branch=Branches::where('id',$request->branch)->first();
        $products=Products::where('branch_id',$branch->bid)->get();
        return view('productview', compact('branch','products'));
    }

    public function newproduct(Request $request){
        $create=Products::create([
            'branch_id' => $request->bid,
            'name' => $request->pname,
            'price' => $request->pprice
        ]);
        if(isset($create))
            return redirect('branches')->with('success','New Product created successfully in '.$request->bid.'.');
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

}
