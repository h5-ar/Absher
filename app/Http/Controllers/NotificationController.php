<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use App\Models\Company;
use App\Models\SuperAdmin;
use App\Notifications\DoneNotification;
use App\Notifications\BlockUserNotification;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\Notification as NotificationModel;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
    public function show($id) {}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        Session::flash('successMessage', translate('Deleted successfully'));
        return to_route('superadmin.notifications.index');
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

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    public function viewBlock()
    {
        return view('Dashboard.Admin.Notification.BlockUser');
    }

    public function Block(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'reason' => 'required|string'
        ]);

        $company = Company::where('id', Auth::id())->first();
        $user = User::where('email', $request->email)->first(); // تغيير من firstOrFail() إلى first()

        if (!$user) {
            Session::flash('successMessage', translate('لم يتم العثوم على المستخدم تاكد من البريد الالكتروني'));

            return redirect()->back()
                ->withInput();
        }

        $reason = $request->reason;

        $super_admins = SuperAdmin::distinct('email')->get();
        Notification::send($super_admins, new BlockUserNotification($company, $user, $reason));
        Session::flash('successMessage', translate('تم إرسال الإشعار بنجاح إلى المشرفين العامين'));

        return redirect()->route('dashboard');
    }
}
