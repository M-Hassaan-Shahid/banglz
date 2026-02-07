<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PreferencesUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public array $preferences;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, array $preferences)
    {
        $this->user = $user;
        $this->preferences = $preferences;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Communication Preferences Updated',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Format preferences for display
        $formattedPreferences = $this->formatPreferences($this->preferences);

        return new Content(
            markdown: 'emails.preferences-updated',
            with: [
                'userName' => $this->user->name,
                'preferences' => $formattedPreferences,
            ],
        );
    }

    /**
     * Format preferences array for email display.
     *
     * @param array $preferences
     * @return array
     */
    private function formatPreferences(array $preferences): array
    {
        $formatted = [];
        $labels = [
            'marketing_emails' => 'Marketing Emails',
            'order_updates' => 'Order Updates',
            'newsletter' => 'Newsletter',
            'product_recommendations' => 'Product Recommendations',
        ];

        foreach ($preferences as $key => $value) {
            if (isset($labels[$key])) {
                $formatted[] = [
                    'label' => $labels[$key],
                    'value' => (bool)$value ? 'Enabled' : 'Disabled',
                ];
            }
        }

        return $formatted;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
