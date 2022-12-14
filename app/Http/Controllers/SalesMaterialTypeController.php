<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesMaterialTypeRequest;
use App\Models\Admin;
use App\Models\Sales_material_type;
use Illuminate\Http\Request;

class SalesMaterialTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Sales_material_type::select()->orderby('id','DESC')->paginate(PAGINATING_COUNT);
        if(!empty($data)){
            foreach($data as $info) {
                $info->added_by_admin =Admin::where('id',$info->added_by)->value('name');
                if($info->updated_by > 0 and $info->updated_by !=null){
                    $info->updated_by_admin =Admin::where('id',$info->updated_by)->value('name');
                }
            }
        }
        return view('admin.sales_material_type.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \view('admin.sales_material_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesMaterialTypeRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            // check if not exists
            $checkExists = Sales_material_type::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {
                $data['name'] = $request->name;
                $data['active'] = $request->active;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['added_by'] = auth()->user()->id;
                $data['com_code']  = $com_code;
                $data['date']= date('Y-m-d');
                Sales_material_type::create($data);
                return redirect()->route('sales_material_types.index')->with(['success' => '?????? ???? ?????????? ???????????????? ??????????']);
            } else {
                // ?????????? ???????????? ??????????   withinput
                return redirect()->back()->with(['error' => '???????? ?????? ?????????? ???????? ???? ?????? '])->withInput();
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => '???????? ?????? ?????? ????!' . $ex->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales_material_type  $sales_material_type
     * @return \Illuminate\Http\Response
     */
    public function show(Sales_material_type $sales_material_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sales_material_type  $sales_material_type
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Sales_material_type::select()->find($id);
        return response()->view('admin.sales_material_type.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sales_material_type  $sales_material_type
     * @return \Illuminate\Http\Response
     */
    public function update($id , SalesMaterialTypeRequest $request)
    {
        try{

            $com_code = auth()->user()->com_code ;
            $data = Sales_material_type::select()->find($id);
            //???????? ?????? ????????????
            if(empty($data)){
                return redirect()->route('sales_material_types.index')->with(['error'=>'???????? ?????? ???????? ?????? ???????????? ???????????????? ???????????????? !!']);
            }

            // ?????? ???????????? ?????? ??????????

            $cheeckExists = Sales_material_type::where(['name'=>$request->name,'com_code'=>$com_code])->where('id','!=',$id)->first();
            if($cheeckExists != null){
                return redirect()->back()
                ->with(['error'=>"???????? ?????? ???????????? ???????? ???? ?????? !"])
                ->withInput();
            }
             $data_to_update['name'] = $request->name;
             $data_to_update['active'] = $request->active;
             $data_to_update['updated_by'] = auth()->user()->id ;
             $data_to_update['updated_at'] = date("Y-m-d  H:i:s") ;
             Sales_material_type::where(['id'=>$id , 'com_code'=>$com_code])->update($data_to_update);

             return redirect()->route('sales_material_types.index')->with(['success'=>'?????? ???? ?????????? ???????????????? ??????????']);

        }catch(\Exception $ex){
            return redirect()->back()
            ->with(['error'=>'???????? ?????? ?????? ????'])
            ->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales_material_type  $sales_material_type
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id){
        try{
            $sales_material_type = Sales_material_type::find($id);
            if(!empty($sales_material_type)){
                $flag =  $sales_material_type->delete();
                if($flag){
                    return redirect()->back()->with(['success'=>'???? ?????? ???????????????? ??????????']);
                }else{
                    return redirect()->back()->with(['error'=>'???????? ?????? ?????? ????' ]);
                }
            }else{
                return redirect()->back()->with(['error'=>'?????? ???????? ?????? ???????????? ?????? ???????????????? ????????????????']);
            }
        }catch(\Exception $ex){
            return redirect()->back()->with(['error' => '???????? ?????? ?????? ????!' . $ex->getMessage()]);

        }
     }

}
