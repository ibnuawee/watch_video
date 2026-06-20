<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoAccessRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        if (!$customer) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Profil customer tidak ditemukan.');
        }

        $customerId = $customer->id;

        $stats = [
            'total_videos' => Video::count(),
            'pending_requests' => VideoAccessRequest::where('customer_id', $customerId)
                ->where('status', 'pending')
                ->count(),
            'active_access' => VideoAccessRequest::where('customer_id', $customerId)
                ->where('status', 'approved')
                ->where('access_start_at', '<=', now())
                ->where('access_end_at', '>=', now())
                ->count(),
            'expired_access' => VideoAccessRequest::where('customer_id', $customerId)
                ->where('status', 'approved')
                ->where('access_end_at', '<', now())
                ->count(),
        ];

        $recentVideos = Video::with('category')->latest()->limit(4)->get();
        
        $lastRequest = VideoAccessRequest::with('video')
            ->where('customer_id', $customerId)
            ->whereHas('video')
            ->latest()
            ->first();

        return view('customer.dashboard', compact('stats', 'recentVideos', 'lastRequest'));
    }
}
