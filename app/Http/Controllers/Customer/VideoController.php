<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\VideoRepositoryInterface;
use App\Repositories\Contracts\VideoAccessRequestRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    protected $videoRepo;
    protected $requestRepo;

    public function __construct(
        VideoRepositoryInterface $videoRepo,
        VideoAccessRequestRepositoryInterface $requestRepo
    ) {
        $this->videoRepo = $videoRepo;
        $this->requestRepo = $requestRepo;
    }

    public function index()
    {
        $customerId = Auth::user()->customer->id;
        $videos = $this->videoRepo->getAllWithCustomerAccessStatus($customerId);
        
        return view('customer.videos.index', compact('videos'));
    }

    public function show(int $id)
    {
        $customerId = Auth::user()->customer->id;
        $video = $this->videoRepo->findById($id);
        
        $videos = $this->videoRepo->getAllWithCustomerAccessStatus($customerId);
        $videoWithAccess = $videos->firstWhere('id', $id);
        $latestRequest = $videoWithAccess ? $videoWithAccess->latestRequest : null;

        return view('customer.videos.show', compact('video', 'latestRequest'));
    }

    public function requestAccess(int $id)
    {
        $customerId = Auth::user()->customer->id;
        
        if ($this->requestRepo->hasPendingOrActiveRequest($customerId, $id)) {
            return back()->with('error', 'Anda sudah memiliki permintaan pending atau akses aktif untuk video ini.');
        }

        $this->requestRepo->createRequest($customerId, $id);

        return back()->with('success', 'Permintaan akses berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function watch(int $id)
    {
        $customerId = Auth::user()->customer->id;
        $video = $this->videoRepo->findById($id);
        
        $activeAccess = $this->requestRepo->getActiveAccess($customerId, $id);

        if (!$activeAccess) {
            return redirect()
                ->route('customer.videos.show', $id)
                ->with('error', 'Akses video tidak tersedia atau sudah berakhir. Silakan ajukan request akses kembali.');
        }

        return view('customer.videos.watch', compact('video', 'activeAccess'));
    }

    public function stream(int $id)
    {
        $customerId = Auth::user()->customer->id;
        $video = $this->videoRepo->findById($id);
        
        $activeAccess = $this->requestRepo->getActiveAccess($customerId, $id);

        if (!$activeAccess) {
            abort(403, 'Akses video tidak tersedia atau sudah berakhir.');
        }

        $path = storage_path('app/public/' . $video->video_path);

        if (!file_exists($path)) {
            abort(404, 'File video tidak ditemukan.');
        }

        return response()->file($path, [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
        ]);
    }
}
