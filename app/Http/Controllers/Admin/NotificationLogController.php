<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use Illuminate\Http\Request;

class NotificationLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = NotificationLog::with(['user', 'collectionRequest'])
            ->when($request->has('failed'), function ($query) {
                return $query->where('success', false);
            })
            ->when($request->has('channel'), function ($query) use ($request) {
                return $query->where('channel', $request->channel);
            })
            ->latest()
            ->paginate(25);

        return view('admin.notifications.index', compact('logs'));
    }

    public function show(NotificationLog $notificationLog)
    {
        return view('admin.notifications.show', compact('notificationLog'));
    }
}
