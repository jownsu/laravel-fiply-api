<?php

namespace App\Http\Controllers\api\company;

use App\Http\Controllers\Controller;
use App\Http\Requests\company\HiringManagerRequest;
use App\Http\Resources\company\HiringManagerCollection;
use App\Http\Resources\post\PostResource;
use App\Models\HiringManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HiringManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $userId = $id == 'me' ? auth()->id() : $id;

        $user = User::where('id', $userId)
            ->with([
                'company' => function($q){
                    $q->select('id', 'user_id', 'name');
                },
                'company.hiringManagers' => function($q){
                    $q->select('company_id', 'firstname', 'lastname', 'email', 'avatar', 'contact_no');
                }
            ])->first();

        if (!$user){
            return response()->error('User Not Found');
        }

        return response()->success(HiringManagerCollection::collection($user->company->hiringManagers));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HiringManagerRequest $request)
    {
        //$hiringManager = auth()->user()->company->hiringManagers()->create($request->validated());

        $hiringManager = new HiringManager($request->validated());


        if($request->hasFile('avatar')){
            $hiringManager->avatar = $request->avatar->store('', 'avatar');
        }

        auth()->user()->company->hiringManagers()->save($hiringManager);

        return response()->success($hiringManager);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HiringManagerRequest $request, HiringManager $hiringManager)
    {
        $this->authorize('update', $hiringManager);

        $input = $request->validated();
        if($request->hasFile('avatar')){
            Storage::disk('avatar')->delete($hiringManager->avatar);
            $input['avatar'] = $request->avatar->store('', 'avatar');
        }
        $hiringManager->update($input);

        return response()->success(new HiringManagerCollection($hiringManager));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HiringManager $hiringManager)
    {
        $this->authorize('delete', $hiringManager);
        Storage::disk('avatar')->delete($hiringManager->avatar);
        $hiringManager->delete();
        return response()->success('Hiring Manager was deleted');
    }
}
