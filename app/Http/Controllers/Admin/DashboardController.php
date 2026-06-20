<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\VideoCategoryRepositoryInterface;
use App\Repositories\Contracts\VideoRepositoryInterface;
use App\Repositories\Contracts\VideoAccessRequestRepositoryInterface;
use App\Models\Customer;
use App\Models\VideoCategory;
use App\Models\Video;
use App\Models\VideoAccessRequest;

class DashboardController extends Controller
{
    protected $customerRepo;
    protected $categoryRepo;
    protected $videoRepo;
    protected $requestRepo;

    public function __construct(
        CustomerRepositoryInterface $customerRepo,
        VideoCategoryRepositoryInterface $categoryRepo,
        VideoRepositoryInterface $videoRepo,
        VideoAccessRequestRepositoryInterface $requestRepo
    ) {
        $this->customerRepo = $customerRepo;
        $this->categoryRepo = $categoryRepo;
        $this->videoRepo = $videoRepo;
        $this->requestRepo = $requestRepo;
    }

    public function index()
    {
        $stats = [
            'total_customers' => Customer::count(),
            'total_categories' => VideoCategory::count(),
            'total_videos' => Video::count(),
            'pending_requests' => VideoAccessRequest::where('status', 'pending')->count(),
            'approved_requests' => VideoAccessRequest::where('status', 'approved')->count(),
            'rejected_requests' => VideoAccessRequest::where('status', 'rejected')->count(),
        ];

        $recentRequests = VideoAccessRequest::with(['customer.user', 'video'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests'));
    }
}
