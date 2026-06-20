<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\VideoAccessRequestRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    protected $requestRepo;

    public function __construct(VideoAccessRequestRepositoryInterface $requestRepo)
    {
        $this->requestRepo = $requestRepo;
    }

    public function index(Request $request)
    {
        $customerId = Auth::user()->customer->id;
        $status = $request->get('status');
        
        $requests = $this->requestRepo->getRequestsByCustomer($customerId, $status);

        return view('customer.requests.index', compact('requests', 'status'));
    }
}
