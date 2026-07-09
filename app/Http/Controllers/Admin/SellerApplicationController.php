<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthorForm;
use App\Models\User;
use Illuminate\Http\Request;

class SellerApplicationController extends Controller
{
    public function index()
    {
        $applications = AuthorForm::with('user')->orderBy('id', 'desc')->get();
        return view('admin.sellers.applications', [
            'pageTitle' => 'Quản lý Đơn đăng ký Người Bán',
        ], compact('applications'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $application = AuthorForm::findOrFail($request->id);
        
        if ($application->status != '0') {
            return redirect()->back()->with('error', 'Đơn này đã được xử lý.');
        }

        $application->status = '1'; // Approved
        $application->save();

        $user = User::find($application->user_id);
        if ($user) {
            $user->level = 2; // Make them seller
            $user->name = $application->shop_name ?? $user->name;
            $user->gioi_thieu = $application->description ?? $user->gioi_thieu;
            if (is_array($application->work_category)) {
                $user->skill = implode(', ', $application->work_category);
            }
            $user->save();
        }

        return redirect()->back()->with('success', 'Đã duyệt đơn đăng ký của ' . ($user->username ?? 'Unknown') . '. Người dùng đã trở thành Người Bán.');
    }

    public function reject(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $application = AuthorForm::findOrFail($request->id);
        
        if ($application->status != '0') {
            return redirect()->back()->with('error', 'Đơn này đã được xử lý.');
        }

        $application->status = '2'; // Rejected
        $application->save();

        return redirect()->back()->with('success', 'Đã từ chối đơn đăng ký.');
    }
}
