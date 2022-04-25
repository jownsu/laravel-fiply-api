<?php

namespace App\Http\Controllers\api\company;

use App\Http\Controllers\Controller;
use App\Http\Requests\company\UploadCertificateRequest;
use App\Http\Requests\company\UploadCompanyIdRequest;
use App\Models\CompanyDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function uploadCompanyId(UploadCompanyIdRequest $request)
    {
        $input = $request->validated();

        $user = auth()->user();

        $doc = $user->company->companyDocument;

        if(!$doc){
            $doc = new CompanyDocument();
        }else{
            Storage::disk('company_id')->delete($doc->valid_id_image_front);
            Storage::disk('company_id')->delete($doc->valid_id_image_back);
        }

        $doc->valid_id             = $input['valid_id'];
        $doc->valid_id_image_front = $input['valid_id_image_front']->store('', 'company_id');
        $doc->valid_id_image_back  = $input['valid_id_image_back']->store('', 'company_id');

        $user->company->companyDocument()->save($doc);

        return response()->success([
            'valid_id'              => $doc->valid_id,
            'valid_id_image_front'  => $doc->valid_id_image_front(),
            'valid_id_image_back'   => $doc->valid_id_image_back(),
        ]);
    }

    public function uploadCertificate(UploadCertificateRequest $request)
    {
        $input = $request->validated();

        $user = auth()->user();

        $doc = $user->company->companyDocument;

        if(!$doc){
            $doc = new CompanyDocument();
        }else{
            Storage::disk('company_certificate')->delete($doc->certificate_image);
        }

        $doc->certificate        = $input['certificate'];
        $doc->certificate_image  = $input['certificate_image']->store('', 'company_certificate');

        $user->company->companyDocument()->save($doc);

        return response()->success([
            'certificate'        => $doc->certificate,
            'certificate_image'  => $doc->certificate_image(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
