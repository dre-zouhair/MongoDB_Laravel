<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function  View(){
        return view('users');
    }
    public function index()
    {
        $m = User::all();
        $datas = Array();
        foreach ($m as $key => $value){
            $datas[$key]['id'] = $value->_id;
            $datas[$key]['name'] = $value->name;
            $datas[$key]['cin'] = $value->cin;
            $datas[$key]['phone'] = $value->phone;
            $datas[$key]['profession'] = $value->profession;
            $datas[$key]['email'] = $value->email;
        }
        return  DataTables($datas)->addColumn('action', function($data){
            if($data['id'] != Auth::user()->_id)
            return '<a href="#" class="btn btn-xs btn-outline-danger delete" id="'.$data['id'].'"> Delete</a>';
        })->make(true);

    }
    public function store(Request $request)
    {
        $error_array = array();
        $success_output = '';
        if($request->get('button_action') == 'insert')
        {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'profession'=>['required','string','max:50'],
                'cin'=>['required','string','max:50'],
                'phone' => 'required|regex:/(0)[0-9]{9}/',
                'is_admin' => 'required',
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);
            $data =[
                    'name' =>  $request->input('name'),
                    'cin' =>  $request->input('cin'),
                    'profession' =>  $request->input('profession'),
                    'email' =>  $request->input('email'),
                    'phone' =>  $request->input('phone'),
                    'is_admin'=>$request->input('is_admin'),
                    'remember_token'=>"",
                    'password'=> Hash::make($request->input('password'))
                ];

            User::Create($data);
            $success_output = '<div class="alert alert-success alert-dismissible  show" role="alert">
                                <strong>User successfully added</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        }
        if($request->get('button_action') == 'update')
        {
            $validatedData = $request->validate([
                'name' => ['required', 'regex:/[a-z][ ]/', 'max:255'],
                'profession'=>['required','string','max:50'],
                'cin'=>['required','string','max:50'],
                'phone' => 'required|regex:/(0)[0-9]{9}/'
            ]);
            $user = User::find($id = Auth::user()->_id);
            $user->profession = $request->input('profession');
            $user->cin = $request->input('cin');
            $user->phone = $request->input('phone');
            $user->name = $request->input('name');
            $user->save();
            $success_output = '<div class="alert alert-success alert-dismissible  show" role="alert">
                                  <stro  <strong>User successfully updated</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        }
        $output = array('error'     =>  $error_array, 'success'   =>  $success_output);
        return json_encode($output);

    }
    public function show()
    {
        $id = Auth::user()->_id;
        $user = User::find($id);
       return view('profile',['user'=>$user]);
    }
    public function destroy(Request $request)
    {
        $success_output = '<div class="alert alert-success alert-dismissible show" role="alert">
                                  <strong>user successfully deleted</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        $output = array('success'   =>  $success_output   );
        if(User::destroy($request->input('id'))) return json_encode($output);
        return array('error'     =>  '<div class="alert alert-danger alert-dismissible show" role="alert">
                                  <strong>user not deleted </strong> something went wrong
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>');
    }
    public function ChangePassowrd(Request $request)
    {
        $validatedData = $request->validate([
            'oldpassword' => ['required','string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        try {
            $current_user =User::find($id = Auth::user()->_id);
            if(Hash::check($request->input('oldpassword'), $current_user->password))
            {
                $user = User::find($current_user->id);
                $user->password = Hash::make($request->input('password'));
                $user->save();
                $response = ['success'=>true, 'data'=>'<div class="alert alert-success alert-dismissible show" role="alert">
                                  <strong>password successfully changer</strong> you would be loged out in few seconds
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>'];
                Auth::logout();
                return response()->json($response, 201);
            }
            else
            {
                $error = array('oldpassword' => 'Please enter correct current password');
                return response()->json(array('errors' => $error), 422);
            }
        } catch (\Illuminate\Database\QueryException $th) {
            $response = ['success'=>false, 'data'=>'<div class="alert alert-danger alert-dismissible show" role="alert">
                                  <strong>The server takes responsibility for these error status codes </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>'];
            return response()->json($response, 501);
        }
    }
    public function ChangeEmail(Request $request)
    {
        $validatedData = $request->validate([
            'oldemail' => ['required','email','string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);
        try {
            $current_user = User::find($id = Auth::user()->_id);
            if($request->input('oldemail')== $current_user->email)
            {
                $user = User::find($current_user->id);
                $user->email = $request->input('email');
                $user->save();
                $response = ['success'=>true, 'data'=>'<div class="alert alert-success alert-dismissible show" role="alert">
                                  <strong>password successfully changer</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>'];
                return response()->json($response, 201);
            }
            else
            {
                $error = array('oldemail' => 'Please enter correct current email');
                return response()->json(array('errors' => $error), 422 );
            }
        } catch (\Illuminate\Database\QueryException $th) {
            $response = ['success'=>false, 'data'=>'<div class="alert alert-danger alert-dismissible show" role="alert">
                                  <strong>The server takes responsibility for these error status codes </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>'];
            return response()->json($response, 501);
        }
    }
}
