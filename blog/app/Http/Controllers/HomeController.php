<?php

namespace App\Http\Controllers;

use App\Medicine;
use App\User;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;
use function Sodium\add;
use Illuminate\Support\Facades\Auth;
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


        if(Auth::user()->is_admin == 1)
        return view('home');
        return view('index');
    }
    public function chart()
    {

        try{
            $data = [ Medicine::all()->where('rss','>',0)->count(),Medicine::all()->where('rss','=',0)->count()];
            $labels =  ['reimbursed by social security', 'not reimbursed by social security'];
            if(sizeof($data) == 0) $data = [];
            $response = ['success'=>true, 'data'=>['labels'=>$labels,'data'=>$data]];
            return response()->json($response, 201);
        }catch (Exception $e){
            $response = ['success'=>false, 'data'=>'<div class="alert alert-danger alert-dismissible show" role="alert">
                                  <strong>Ooops !  </strong>something went wrong
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>'];

            return response()->json($response, 501);

        }
    }
    public function chartuser()
    {

        try{
            $labels = Array();
            $data = Array();
            $user = User::select('profession')->get();
            foreach($user->groupBy('profession')->map(function($values) {return $values->count(); }) as $key => $value){

                array_push($data,$value);
                array_push($labels,$key);
            }

            $response = ['success'=>true, 'data'=>['labels'=>$labels,'data'=>$data]];
            return response()->json($response, 201);
        }catch (Exception $e){

            $response = ['success'=>false, 'data'=>'<div class="alert alert-danger alert-dismissible show" role="alert">
                                  <strong>Ooops !  </strong>something went wrong
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>'];
            return response()->json($response, 501);

        }
    }
}
