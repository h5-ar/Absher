<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use App\Models\Company;
use App\Models\SuperAdmin;
use App\Notifications\DoneNotification;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\Notification as NotificationModel;

class SANotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = DB::table('notifications')->where('notifiable_type', get_class(auth()->user()))
            ->where('notifiable_id', auth()->id())
            ->paginate(10);

        if (request()->ajax()) {
            return view('DashboardSuperAdmin.SuperAdmin.Notification.Section.indexTable', compact('notifications'));
        }
        return view('DashboardSuperAdmin.SuperAdmin.Notification.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $notification = DatabaseNotification::where('id', $id)
            ->where('notifiable_type', get_class(auth()->user()))
            ->where('notifiable_id', auth()->id())
            ->firstOrFail();
        // dd($notification);


        $super_admin = SuperAdmin::where('id', Auth::id())->first();

        $companyId = $notification->data['company']['id'];
        // dd($companyId);
        $message = $notification->data['user']['first_name'] . ' ' .
            $notification->data['user']['last_name'] . ' ' .
            $notification->data['reason'] . ' تم المعالجة';
        // dd($message);


        $company = Company::where('id', $companyId)->first();
        // dd($company);


        Notification::send($company, new DoneNotification($company, $message, $super_admin));


        return view('DashboardSuperAdmin.SuperAdmin.Notification.show', [
            'notification' => $notification
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notification =  DB::table('notifications')->where('id', $id);
        $notification->delete();
        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('SAnotifications.index');
    }
    public function details($id)
    {
        $notification = DatabaseNotification::where('id', $id)
            ->where('notifiable_type', get_class(auth()->user()))
            ->where('notifiable_id', auth()->id())
            ->firstOrFail();
        return view('DashboardSuperAdmin.SuperAdmin.Notification.details', [
            'notification' => $notification
        ]);
    }
    public function read($id)
    {
        $notification = DatabaseNotification::where('id', $id)
            ->where('notifiable_type', get_class(auth()->user()))
            ->where('notifiable_id', auth()->id())
            ->firstOrFail();

        $notification->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }
}
