<?php

namespace App\Http\Controllers;

use App\Medicine as Medicament;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class MedicineController extends Controller
{
    public function View()
    {
        return view('medicines');
    }

    public function index()
    {
        $m = Medicament::all();
        $datas = Array(Array());
        foreach ($m as $key => $value){
            $datas[$key]['id'] = $value->_id;
            $datas[$key]['commercial_name'] = $value->commercial_name;
            $datas[$key]['active_substance'] = $value->active_substance;
            $datas[$key]['price'] = $value->price;
            $datas[$key]['barre_code'] = $value->barre_code;
            $datas[$key]['prescription'] = $value->prescription;
            $datas[$key]['rss'] = $value->rss;
            $datas[$key]['laboratory'] = $value->laboratory['name']." (".$value->laboratory['designation'].")";
        }
        return  DataTables($datas)->addColumn('action', function($data){
            return '<a href="#" class="btn btn-xs btn-outline-warning edit" style="margin-right: 10px;" id="'.$data['id'].'"> Edit</a>'.'<a href="#" class="btn btn-xs btn-outline-danger delete" id="'.$data['id'].'"> Delete</a>';
        })->make(true);

    }


    public function store(Request $request)
    {
        $error_array = array();
        $success_output = '';

        if($request->get('button_action') == 'insert')
        {
            $validatedData = $request->validate([

                'commercial_name' => 'required|string|max:255',
                'active_substance' => 'required|string',
                'price' => 'required|numeric',
                "barre_code" => 'required|numeric|unique:medicines',
                "prescription" => 'required',
                "rss" => 'required|numeric',
                "name" => 'required|string|max:255',
                "designation" => 'required|string'
            ]);

           Medicament::Create([
               "commercial_name"=> $request->input('commercial_name'),
               "active_substance"=> $request->input('active_substance'),
               "price"=>$request->input('price'),
               "barre_code" => $request->input('barre_code'),
               "prescription" => $request->input('prescription'),
               "rss" => $request->input('rss'),
               "laboratory" => [
                   "name"=> $request->input('name'),
                   "designation" => $request->input('designation')
               ]
           ]);
            $success_output = '<div class="alert alert-success alert-dismissible show" role="alert">
                                  <strong>Medicine successfully added</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        }

        if($request->get('button_action') == 'update')
        {
            if((Medicament::where('barre_code',$request->input('barre_code'))->first())->_id==$request->input('id'))
                $validatedData = $request->validate([
                    'commercial_name' => 'required|string|max:255',
                    'active_substance' => 'required|string',
                    'price' => 'required|numeric',
                    "barre_code" => 'required|numeric',
                    "prescription" => 'required',
                    "rss" => 'required|numeric',
                    "name" => 'required|string|max:255',
                    "designation" => 'required|string'
                ]);

            else  $validatedData = $request->validate([
                'commercial_name' => 'required|string|max:255',
                'active_substance' => 'required|string',
                'price' => 'required|numeric',
                "barre_code" => 'required|numeric|unique:medicines',
                "prescription" => 'required',
                "rss" => 'required|numeric',
                "name" => 'required|string|max:255',
                "designation" => 'required|string'
            ]);


            $medicament = Medicament::find($request->input('id'));
            $medicament->price = $request->input('price');
            $medicament->commercial_name = $request->input('commercial_name');
            $medicament->active_substance = $request->input('active_substance');
            $medicament->barre_code = $request->input('barre_code');
            $medicament->rss = $request->input('rss');
            $medicament->prescription = $request->input('prescription');
            $medicament->laboratory = ['name' =>  $request->input('name'),'designation' => $request->input('designation')];
            $medicament->save();
            $success_output = '<div class="alert alert-success alert-dismissible show" role="alert">
                                  <strong>Medicine successfully updated</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
        }



        $output = array('error'     =>  $error_array, 'success'   =>  $success_output);
        return json_encode($output);

    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $medicament = Medicament::find($id);
        $output = array(
            'id'=>$id,
            'commercial_name' =>  $medicament->commercial_name,
            'active_substance' =>  $medicament->active_substance,
            'price' =>  $medicament->price,
            'barre_code' =>  $medicament->barre_code,
            'rss' =>  $medicament->rss,
            'prescription' =>  $medicament->prescription,
            'name' =>  $medicament->laboratory['name'],
            'designation' =>  $medicament->laboratory['designation']
        );
        echo json_encode($output);
    }

    public function destroy(Request $request)
    {
        $output = array('success'   =>  '<div class="alert alert-success alert-dismissible show" role="alert">
                                  <strong>Medicine successfully deleted</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>'    );
        if(Medicament::destroy($request->input('id'))) return json_encode($output);
        return array('error'     =>  '<div class="alert alert-danger alert-dismissible show" role="alert">
                                  <strong>Medicine not deleted </strong> something went wrong
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>');
    }
}
