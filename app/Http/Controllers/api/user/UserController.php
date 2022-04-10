<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\UploadAvatarRequest;
use App\Http\Requests\user\UploadCoverRequest;
use App\Http\Requests\user\UploadResumeRequest;
use App\Http\Requests\user\UploadValidIdRequest;
use App\Http\Resources\user\ProfileResource;
use App\Models\Document;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index($id)
    {
        $userid = $id == 'me' ? auth()->id() : $id;
        $myId = auth()->id();

        $user = User::findOrFail($userid)
                    ->load('profile')
                    ->loadCount([
                        'following' => function($q){
                            $q->where('accepted', 1);
                        }, 'followers' => function($q){
                            $q->where('accepted', 1);
                        },
                        'followers AS is_following' => function($q) use($myId) {
                            $q->where('user_id', $myId)->where('accepted', true);
                        },
                        'followers AS is_following_pending' => function($q) use($myId) {
                            $q->where('user_id', $myId)->where('accepted', false);
                        }
                    ]);

        $user->is_me = ($id == 'me') ? true : false;

        return response()->success(new ProfileResource($user));
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

    public function uploadAvatar(UploadAvatarRequest $request)
    {
        $input = $request->validated();

        $user = auth()->user();

        $userProfile = $user->profile;

        Storage::disk('avatar')->delete($user->profile->avatar);
        $userProfile->avatar = $input['avatar']->store('', 'avatar');
        $userProfile->save();


        return response()->success($user->profile->avatar());
    }

    public function uploadCover(UploadCoverRequest $request)
    {
        $input = $request->validated();

        $user = auth()->user();

        $userProfile = $user->profile;

        //Storage::delete($user->profile->avatar);
        Storage::disk('cover')->delete($user->profile->cover);
        $userProfile->cover = $input['cover']->store('', 'cover');
        $userProfile->save();

        return response()->success($user->profile->cover());
    }

    public function uploadResume(UploadResumeRequest $request)
    {
        $input = $request->validated();

        $user = auth()->user();

        $doc = $user->document;

        if(!$doc){
            $doc = new Document();
        }else{
            Storage::disk('resume')->delete($doc->resume);
        }

        $doc->resume = $input['resume']->store('', 'resume');

        $user->document()->save($doc);

        return response()->success($doc->resume());
    }

    public function uploadValidId(UploadValidIdRequest $request)
    {
        $input = $request->validated();

        $user = auth()->user();

        $doc = $user->document;

        if(!$doc){
            $doc = new Document();
        }else{
            Storage::disk('id')->delete($doc->valid_id_image_front);
            Storage::disk('id')->delete($doc->valid_id_image_back);
        }

        $doc->valid_id             = $input['valid_id'];
        $doc->valid_id_image_front = $input['valid_id_image_front']->store('', 'id');
        $doc->valid_id_image_back  = $input['valid_id_image_back']->store('', 'id');

        $user->document()->save($doc);

        return response()->success([
            'valid_id'              => $doc->valid_id,
            'valid_id_image_front'  => $doc->valid_id_image_front(),
            'valid_id_image_back'   => $doc->valid_id_image_back(),
        ]);

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
