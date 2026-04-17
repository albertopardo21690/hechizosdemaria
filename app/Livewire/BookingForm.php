<?php

namespace App\Livewire;

use App\Mail\BookingStatusChanged;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Coupon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class BookingForm extends Component
{
    public int $step = 1;

    public ?int $serviceId = null;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public ?string $preferredDate = null;

    public string $preferredTime = '';

    public string $notes = '';

    public string $deliveryMethod = 'whatsapp';

    public string $couponCode = '';

    public ?string $couponMessage = null;

    public ?string $couponError = null;

    public float $discount = 0;

    public bool $useWhatsapp = false;

    public ?Booking $createdBooking = null;

    public function selectService(int $id): void
    {
        $this->serviceId = $id;
        $service = BookingService::find($id);
        if ($service) {
            $this->deliveryMethod = $service->delivery_method;
        }
        $this->step = 2;
    }

    public function goToStep(int $step): void
    {
        $this->step = $step;
    }

    public function applyCoupon(): void
    {
        $this->couponMessage = null;
        $this->couponError = null;
        $code = strtolower(trim($this->couponCode));
        $coupon = $code ? Coupon::findByCode($code) : null;
        if (! $coupon) {
            $this->couponError = 'Cupón no encontrado.';

            return;
        }
        $service = BookingService::find($this->serviceId);
        $price = $service ? (float) $service->price : 0;
        if (! $coupon->isValid($price)) {
            $this->couponError = 'Cupón no válido.';

            return;
        }
        $this->discount = $coupon->discount($price);
        $this->couponMessage = "Cupón «{$coupon->code}» aplicado: -{$this->discount}€";
    }

    public function submitBooking(): void
    {
        $this->validate([
            'serviceId' => 'required|exists:booking_services,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:40',
        ]);

        $service = BookingService::findOrFail($this->serviceId);

        $booking = Booking::create([
            'booking_service_id' => $service->id,
            'customer_name' => $this->name,
            'customer_email' => $this->email,
            'customer_phone' => $this->phone,
            'preferred_date' => $this->preferredDate ?: null,
            'preferred_time' => $this->preferredTime ?: null,
            'customer_notes' => $this->notes,
            'delivery_method' => $this->deliveryMethod,
            'price' => $service->price,
            'discount' => $this->discount,
            'coupon_code' => $this->discount > 0 ? $this->couponCode : null,
            'payment_status' => $service->requires_payment ? 'pending' : 'free',
            'ip' => request()->ip(),
            'status' => 'pending',
        ]);

        if ($this->discount > 0 && $this->couponCode) {
            Coupon::findByCode($this->couponCode)?->incrementUsage();
        }

        // Notify María José by email
        try {
            Mail::raw(
                "Nueva reserva #{$booking->reference}\n\n"
                ."Servicio: {$service->name}\n"
                ."Cliente: {$booking->customer_name} ({$booking->customer_email})\n"
                ."Teléfono: {$booking->customer_phone}\n"
                ."Fecha: ".($booking->preferred_date?->format('d/m/Y') ?? 'Flexible')."\n"
                ."Notas: {$booking->customer_notes}\n"
                ."Precio: {$booking->finalPrice()}€\n\n"
                ."Gestionar: ".route('admin.bookings.show', $booking),
                fn ($m) => $m->to('hechizosdemaria@gmail.com')->subject("Nueva reserva #{$booking->reference}")
            );
        } catch (\Throwable $e) {
            report($e);
        }

        $this->createdBooking = $booking;
        $this->useWhatsapp = false;
        $this->step = 'success';
    }

    public function chooseWhatsapp(): void
    {
        $this->useWhatsapp = true;
    }

    public function render()
    {
        return view('livewire.booking-form', [
            'services' => BookingService::catalog()->get(),
            'selectedService' => $this->serviceId ? BookingService::find($this->serviceId) : null,
        ]);
    }
}
