<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Objective;
use App\KeyResult;

class MyOKRsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $okrs = [];
        $objectives = Objective::where('user_id','=',auth()->user()->id)->orderBy('finished_at')->get();
        foreach ($objectives as $obj) {
            $okrs[] = [
                "objective" => $obj,
                "keyresults" => $obj->keyresults()->getResults(),
            ];
        }

        $data = [
            'okrs' => $okrs,
        ];

        return view('okrs.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('okrs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeObjective(Request $request)
    {
        $attr['user_id'] = auth()->user()->id;
        $attr['title'] = $request->input('obj_title');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');

        Objective::create($attr);

        return redirect()->route('okrs.index');
    }
    public function storeKR(Request $request)
    {
        $attr['objective_id'] = $request->input('krs_owner');
        $attr['title'] = $request->input('krs_title');
        $attr['confidence'] = $request->input('krs_conf');
        $attr['initial_value'] = $request->input('krs_init');
        $attr['target_value'] = $request->input('krs_tar');
        $attr['current_value'] = $request->input('krs_now');
        $attr['weight'] = $request->input('krs_weight');

        KeyResult::create($attr);
        return redirect()->route('okrs.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Objective $objective)
    {
        //使用者的krs
        $keyresults = KeyResult::where('objective_id','=',$objective->id)->get();  
        $data = [
            'objective' => $objective,
            'keyresults'=> $keyresults,
        ];
        return view('okrs.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Objective $objective)
    {
        $objAttr['title'] = $request->input('obj_title');
        $objAttr['started_at'] = $request->input('st_date');
        $objAttr['finished_at'] = $request->input('fin_date');
        $objective->update($objAttr);

        $keyresults = KeyResult::where('objective_id','=',$objective->id)->get();  
        foreach ($keyresults as $keyresult) {
            $krAttr['title'] = $request->input('krs_title'.$keyresult->id);
            $krAttr['confidence'] = $request->input('krs_conf'.$keyresult->id);
            $krAttr['initial_value'] = $request->input('krs_init'.$keyresult->id);
            $krAttr['target_value'] = $request->input('krs_tar'.$keyresult->id);
            $krAttr['current_value'] = $request->input('krs_now'.$keyresult->id);
            $krAttr['weight'] = $request->input('krs_weight'.$keyresult->id);
            $keyresult->update($krAttr);
        }
       
        return redirect()->route('okrs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyObjective(Objective $objective)
    {
        //$objids = Objective::where('owner','=',auth()->user()->id)->pluck('id');
        // KeyResult::where('owner','=',$objective->id)->delete();
        $objective->delete();
        return redirect()->route('okrs.index');
    }
    public function destroyKR(KeyResult $keyresult)
    {
        $keyresult->delete();
        return redirect()->route('okrs.index');
    }
}
