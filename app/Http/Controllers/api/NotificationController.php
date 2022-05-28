<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationCollection;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        $notifs = auth()->user()->notifications;

        return response()->success(NotificationCollection::collection($notifs));
    }

    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);

        $notification->delete();

        return response()->success('deleted');
    }
}
