<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\CompanyCollection;
use App\Http\Resources\admin\CompanyProfileResource;
use App\Http\Resources\admin\JobseekerProfileResource;
use App\Models\CompanyDocument;
use App\Models\Document;
use App\Models\Notification;
use App\Models\User;
use App\Services\CommunityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        $jobseekers_count = User::whereHas('profile')->count();
        $company_count = User::whereHas('company')->count();
        $company_request_count = User::whereHas('company.companyDocument', function($q){
            $q->where('status', false)
                ->where('valid_id', '!=', '')
                ->where('valid_id_image_front', '!=', '')
                ->where('valid_id_image_back', '!=', '')
                ->where('certificate', '!=', '')
                ->where('certificate_image', '!=', '')
                ->whereNotNull('valid_id')
                ->whereNotNull('valid_id_image_front')
                ->whereNotNull('valid_id_image_back')
                ->whereNotNull('certificate')
                ->whereNotNull('certificate_image');
        })->count();
        $jobseeker_request_count = User::whereHas('document', function($q){
            $q->where('status', false)
                ->where('valid_id', '!=', '')
                ->where('valid_id_image_front', '!=', '')
                ->where('valid_id_image_back', '!=', '')
                ->whereNotNull('valid_id')
                ->whereNotNull('valid_id_image_front')
                ->whereNotNull('valid_id_image_back');
        })->count();

        return response()->success([
            'jobseekers_count'        => $jobseekers_count,
            'company_count'           => $company_count,
            'jobseeker_request_count' => $jobseeker_request_count,
            'company_request_count'   => $company_request_count,
        ]);
    }

    public function getJobSeekers()
    {
        $users = (new CommunityService())->getJobSeekers();
        return response()->successPaginated($users);
    }

    public function getJobSeeker($id)
    {
        $user = User::where('id', $id)
            ->with([
                'profile',
                'educationalBackgrounds',
                'experiences',
                'document'
            ])
            ->whereHas('profile')
            ->first();

        if(!$user){
            return response()->error('Object not found');
        }

        return response()->success(new JobseekerProfileResource($user));
    }

    public function getCompanies()
    {
        $users = (new CommunityService())->getCompanies();
        return response()->successPaginated($users);
    }

    public function getCompany($id)
    {
        $company = User::where('id', $id)
                ->with([
                    'company',
                    'company.hiringManagers',
                    'company.companyDocument'
                ])
                ->whereHas('company')
                ->first();

        if(!$company){
            return response()->error('Object not found');
        }

        return response()->success(new CompanyProfileResource($company));
    }

    public function getCompaniesRequests()
    {
        $users = (new CommunityService())->getCompanyRequests();
        return response()->successPaginated($users);
    }

    public function getJobSeekerRequests()
    {
        $users = (new CommunityService())->getJobSeekerRequests();
        return response()->successPaginated($users);
    }

    public function verifyJobSeeker(Request $request)
    {
        $input = $request->validate([
            'doc_id'  => ['required'],
            'title'   => ['nullable'],
            'message' => ['nullable']
        ]);

        $doc = Document::where('id', $input['doc_id'])
                ->where('status', false)
                ->where('valid_id', '!=', '')
                ->where('valid_id_image_front', '!=', '')
                ->where('valid_id_image_back', '!=', '')
                ->whereNotNull('valid_id')
                ->whereNotNull('valid_id_image_front')
                ->whereNotNull('valid_id_image_back')
                ->first();

        if(!$doc){
            return response()->error('Object not found');
        }

        Notification::create([
            'user_id' => $doc->user_id,
            'title'   => $input['title'] ?? 'Your are now verified',
            'message' => $input['message'] ?? 'Your valid ID is accepted, you are now fully verified',
        ]);

        $doc->status = true;
        $doc->save();

        return response()->success($doc);
    }

    public function verifyCompany(Request $request)
    {
        $input = $request->validate([
            'doc_id'  => ['required'],
            'title'   => ['nullable'],
            'message' => ['nullable']
        ]);

        $doc = CompanyDocument::where('id', $input['doc_id'])
                ->where('valid_id', '!=', '')
                ->where('valid_id_image_front', '!=', '')
                ->where('valid_id_image_back', '!=', '')
                ->where('certificate', '!=', '')
                ->where('certificate_image', '!=', '')
                ->whereNotNull('valid_id')
                ->whereNotNull('valid_id_image_front')
                ->whereNotNull('valid_id_image_back')
                ->whereNotNull('certificate')
                ->whereNotNull('certificate_image')
                ->with(['company' => function($q){
                    $q->select('id', 'user_id');
                }])
                ->first();

        if(!$doc){
            return response()->error('Object not found');
        }

        Notification::create([
            'user_id' => $doc->company->user_id,
            'title'   => $input['title'] ?? 'Your are now verified',
            'message' => $input['message'] ?? 'Your valid ID and certificate are accepted, you are now fully verified',
        ]);

        $doc->status = true;
        $doc->save();

        return response()->success($doc);
    }

    public function rejectJobSeeker(Request $request)
    {
        $input = $request->validate([
            'doc_id'  => ['required'],
            'title'   => ['nullable'],
            'message' => ['nullable']
        ]);

        $doc = Document::where('id', $input['doc_id'])
            ->where('status', false)
            ->where('valid_id', '!=', '')
            ->where('valid_id_image_front', '!=', '')
            ->where('valid_id_image_back', '!=', '')
            ->whereNotNull('valid_id')
            ->whereNotNull('valid_id_image_front')
            ->whereNotNull('valid_id_image_back')
            ->first();

        if(!$doc){
            return response()->error('Object not found');
        }

        Notification::create([
            'user_id' => $doc->user_id,
            'title'   => $input['title'] ?? 'Your Valid ID is rejected',
            'message' => $input['message'] ?? 'We checked your Valid ID and it is not reached our standard',
        ]);

        Storage::disk('id')->delete($doc->valid_id_image_front);
        Storage::disk('id')->delete($doc->valid_id_image_back);

        $doc->valid_id_image_front = null;
        $doc->valid_id_image_back = null;
        $doc->valid_id = null;
        $doc->status = false;
        $doc->save();



        return response()->success($doc);
    }

    public function rejectCompany(Request $request)
    {
        $input = $request->validate([
            'doc_id'  => ['required'],
            'title'   => ['nullable'],
            'message' => ['nullable']
        ]);

        $doc = CompanyDocument::where('id', $input['doc_id'])
            ->where('valid_id', '!=', '')
            ->where('valid_id_image_front', '!=', '')
            ->where('valid_id_image_back', '!=', '')
            ->where('certificate', '!=', '')
            ->where('certificate_image', '!=', '')
            ->whereNotNull('valid_id')
            ->whereNotNull('valid_id_image_front')
            ->whereNotNull('valid_id_image_back')
            ->whereNotNull('certificate')
            ->whereNotNull('certificate_image')
            ->with(['company' => function($q){
                $q->select('id', 'user_id');
            }])
            ->first();

        if(!$doc){
            return response()->error('Object not found');
        }

        Notification::create([
            'user_id' => $doc->company->user_id,
            'title'   => $input['title'] ?? 'Your Valid ID/Certificate is rejected',
            'message' => $input['message'] ?? 'We checked your Valid ID/Certificate and it is not reached our standard',
        ]);

        Storage::disk('company_id')->delete($doc->valid_id_image_front);
        Storage::disk('company_id')->delete($doc->valid_id_image_back);
        Storage::disk('company_certificate')->delete($doc->certificate_image);

        $doc->valid_id_image_front = null;
        $doc->valid_id_image_back = null;
        $doc->valid_id = null;
        $doc->certificate = null;
        $doc->certificate_image = null;
        $doc->status = false;
        $doc->save();



        return response()->success($doc);
    }

}
