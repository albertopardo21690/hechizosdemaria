<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingStatusChanged;
use App\Models\Booking;
use App\Models\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('service')->orderByDesc('created_at');
        if ($s = $request->get('status')) {
            $query->where('status', $s);
        }
        if ($q = $request->get('q')) {
            $query->where(fn ($qb) => $qb->where('customer_name', 'like', "%{$q}%")
                ->orWhere('customer_email', 'like', "%{$q}%")
                ->orWhere('reference', 'like', "%{$q}%"));
        }
        $bookings = $query->paginate(25)->withQueryString();
        $counts = Booking::selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status');

        return view('admin.bookings.index', compact('bookings', 'counts'));
    }

    public function show(Booking $booking)
    {
        $booking->load('service', 'customer');

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'status' => 'required|in:'.implode(',', array_keys(Booking::STATUSES)),
            'admin_notes' => 'nullable|string|max:2000',
        ]);
        $oldStatus = $booking->status;
        $booking->update([
            'status' => $data['status'],
            'admin_notes' => $data['admin_notes'] ?? $booking->admin_notes,
            'accepted_at' => $data['status'] === 'accepted' && ! $booking->accepted_at ? now() : $booking->accepted_at,
            'completed_at' => $data['status'] === 'completed' && ! $booking->completed_at ? now() : $booking->completed_at,
            'cancelled_at' => in_array($data['status'], ['cancelled', 'rejected']) && ! $booking->cancelled_at ? now() : $booking->cancelled_at,
        ]);

        if ($oldStatus !== $data['status'] && $booking->customer_email) {
            try {
                Mail::to($booking->customer_email)->send(new BookingStatusChanged($booking));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return back()->with('status', 'Estado actualizado a: '.Booking::STATUSES[$data['status']]);
    }

    public function services()
    {
        $services = BookingService::orderBy('sort')->get();

        return view('admin.bookings.services', compact('services'));
    }

    public function createService()
    {
        return view('admin.bookings.service-form', ['service' => null]);
    }

    public function storeService(Request $request)
    {
        $data = $this->validateService($request);
        BookingService::create($data);

        return redirect()->route('admin.bookings.services')->with('status', 'Servicio creado.');
    }

    public function editService(BookingService $service)
    {
        return view('admin.bookings.service-form', compact('service'));
    }

    public function updateService(Request $request, BookingService $service)
    {
        $data = $this->validateService($request, $service);
        $service->update($data);

        return redirect()->route('admin.bookings.services')->with('status', 'Servicio actualizado.');
    }

    public function destroyService(BookingService $service)
    {
        $service->delete();

        return redirect()->route('admin.bookings.services')->with('status', 'Servicio eliminado.');
    }

    protected function validateService(Request $request, ?BookingService $service = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:booking_services,slug'.($service ? ','.$service->id : ''),
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'category' => 'required|string|max:50',
            'delivery_method' => 'required|string|max:50',
            'is_active' => 'boolean',
            'requires_payment' => 'boolean',
            'show_in_catalog' => 'boolean',
            'sort' => 'nullable|integer',
        ]);
    }
}
