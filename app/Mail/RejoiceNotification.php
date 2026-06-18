<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Generic Rejoice transactional email. The body view receives $heading and
 * $lines so the same template renders welcome / review / approval messages.
 */
class RejoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $subjectLine;
    public string $heading;
    public array $lines;

    public function __construct(string $subjectLine, string $heading, array $lines)
    {
        $this->subjectLine = $subjectLine;
        $this->heading = $heading;
        $this->lines = $lines;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.rejoice.notification');
    }

    /**
     * Send one of the predefined Rejoice emails to an address, swallowing any
     * transport errors so review/onboarding actions never fail on mail issues.
     */
    public static function sendTo(?string $email, string $type): void
    {
        if (empty($email)) {
            return;
        }

        $templates = [
            'welcome' => [
                'Welcome to Rejoice Pages',
                'Welcome to Rejoice Pages',
                ['Your Rejoice Page is ready to set up. Add your content, testimony, links, support options, bookings, and Rejoice Audio interest so people can find your work in one place.'],
            ],
            'submitted' => [
                'Your Rejoice Page has been submitted for review',
                'Submitted for review',
                ['Thank you for creating a Rejoice Page. Our team will review your page for basic trust, safety, and alignment before publication.'],
            ],
            'approved' => [
                'Your Rejoice Page is live',
                'Your page is live',
                ['Your page has been approved and is now live. You can continue updating your links, media, support options, and Rejoice Audio onboarding details.'],
            ],
            'changes' => [
                'Changes requested for your Rejoice Page',
                'Changes requested',
                ['We reviewed your page and need a few changes before approval. Please review the notes in your dashboard.'],
            ],
        ];

        if (!isset($templates[$type])) {
            return;
        }

        [$subject, $heading, $lines] = $templates[$type];

        try {
            \Illuminate\Support\Facades\Mail::to($email)
                ->send(new self($subject, $heading, $lines));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Rejoice email failed: ' . $e->getMessage());
        }
    }
}
