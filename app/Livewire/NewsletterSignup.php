<?php

namespace App\Livewire;

use App\Models\FormSubmission;
use Livewire\Component;

class NewsletterSignup extends Component
{
    public string $email = '';

    public bool $success = false;

    public ?string $error = null;

    public function subscribe(): void
    {
        $this->validate(['email' => 'required|email']);

        $exists = FormSubmission::where('form_name', 'newsletter')
            ->where('email', $this->email)
            ->exists();

        if ($exists) {
            $this->error = 'Este email ya está suscrito.';

            return;
        }

        FormSubmission::create([
            'form_name' => 'newsletter',
            'source_url' => request()->url(),
            'data' => ['email' => $this->email],
            'email' => $this->email,
            'ip' => request()->ip(),
        ]);

        // TODO: When Mailchimp API key is available, add subscriber:
        // Http::withToken($apiKey)->post("https://us1.api.mailchimp.com/3.0/lists/{$listId}/members", [
        //     'email_address' => $this->email,
        //     'status' => 'subscribed',
        // ]);

        $this->success = true;
        $this->email = '';
        $this->error = null;
    }

    public function render()
    {
        return view('livewire.newsletter-signup');
    }
}
