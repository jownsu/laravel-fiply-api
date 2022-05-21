<?php

namespace App\Http\Controllers\api\datasets;

use App\Http\Controllers\Controller;
use App\Models\dataset\CompanyCertificate;
use Illuminate\Http\Request;

class CompanyCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->success(CompanyCertificate::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => ['required', 'min:2']
        ]);

        $response = CompanyCertificate::create($input);
        return response()->success($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyCertificate $companyCertificate)
    {
        $input = $request->validate([
            'name' => ['required', 'min:2']
        ]);

        $response = $companyCertificate->update($input);
        return response()->success($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyCertificate $companyCertificate)
    {
      if($companyCertificate->delete()){
          return response()->success('Deleted');
      }
      return response()->error('There is an error while deleting');
    }
}
