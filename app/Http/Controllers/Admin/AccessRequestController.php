<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\VideoAccessRequestRepositoryInterface;
use Illuminate\Http\Request;

class AccessRequestController extends Controller
{
    protected $requestRepo;

    public function __construct(VideoAccessRequestRepositoryInterface $requestRepo)
    {
        $this->requestRepo = $requestRepo;
    }

    public function index(Request $request)
    {
        $status = $request->get('status');
        $requests = $this->requestRepo->allPaginated(10, $status);
        return view('admin.access-requests.index', compact('requests', 'status'));
    }

    public function show(int $id)
    {
        $accessRequest = $this->requestRepo->findById($id);
        return view('admin.access-requests.show', compact('accessRequest'));
    }

    public function approve(Request $request, int $id)
    {
        $validated = $request->validate([
            'access_start_at' => ['required', 'date'],
            'access_end_at' => ['required', 'date', 'after:access_start_at'],
        ]);

        $this->requestRepo->approveRequest(
            $id,
            $validated['access_start_at'],
            $validated['access_end_at']
        );

        return redirect()
            ->route('admin.access-requests.index')
            ->with('success', 'Permintaan akses berhasil disetujui.');
    }

    public function reject(int $id)
    {
        $this->requestRepo->rejectRequest($id);

        return redirect()
            ->route('admin.access-requests.index')
            ->with('success', 'Permintaan akses berhasil ditolak.');
    }
}
