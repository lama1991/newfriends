<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollegeResource;
use App\Http\Resources\SpecializationResource;
use App\Models\College;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\UploadTrait;
class CollegeController extends Controller
{
    use GeneralTrait,UploadTrait;
   
    public function index()
    {
        try{
         $colleges=College::all();
        $data=CollegeResource::collection( $colleges);
        return  $this-> apiResponse($data,true,'all colleges are here ',200);
       
        }
       catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage(),500);
        }
    }


    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|string',
             'category_id'=>  'required|numeric',
             'logo2'=>'required|image'
            ]
        );
                if($validator->fails()){
                    return $this-> apiResponse([], false,$validator->errors(),422);
        }
      try {
       
          $uuid = Str::uuid()->toString();
           $data= $validator->validated();
          $data['uuid']=$uuid;
          if($request->hasFile('logo2'))
          {
           $file=$request->file('logo2');
           $path=$this-> uploadOne($file, 'colleges');
        
        $data['logo']=$path;

          }
          $college=College::create($data);
          $msg='college is created successfully';
         return  $this-> apiResponse( $college,true, $msg,201);
       
        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }


    public function show($id)
    {
        try {
            $college=College::find($id);
            if(!$college)
            {
                return  $this-> apiResponse((object)[],false,'no college with such id',404);
            }
            $msg='college is here';
            $data=new CollegeResource($college);
           return  $this-> apiResponse($data,true, $msg,200);
          }
          catch (\Exception $ex)
          {
              return $this->apiResponse([], false,$ex->getMessage() ,500);
          }
    }

    public function specializationsof($id)
    {
        try
        {
         $college=College::find($id);
        if(!$college)
        {
             return  $this-> apiResponse((object)[],false,'no college with such id',404);
        }
       $specializations=$college->specializations;
        $data=SpecializationResource::collection( $specializations);
        return  $this-> apiResponse($data,true,'all specializations of college are here ',200);
        }
        catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage(),500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function edit(College $college)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, College $college)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function destroy(College $college)
    {
        //
    }
}
