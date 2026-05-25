<?php

use App\Notifications\PlatformUpdateNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('notification:test {email} {--name=Pengguna CareerBridge}', function (string $email) {
    $recipient = new class($email, (string) $this->option('name')) {
        use Notifiable;

        public function __construct(
            public string $email,
            public string $name,
        ) {
        }

        public function routeNotificationForMail(): string
        {
            return $this->email;
        }
    };

    try {
        Notification::send($recipient, new PlatformUpdateNotification(
            'Tes Notifikasi CareerBridge',
            'Ini adalah email uji coba dari sistem notifikasi CareerBridge. Jika email ini masuk, fitur notifikasi sudah siap untuk demo.',
            config('app.url').'/dashboard',
            'Buka Dashboard',
        ));
    } catch (Throwable $exception) {
        $this->error('Notifikasi gagal dikirim.');
        $this->line('Mailer aktif: '.config('mail.default'));
        $this->line($exception->getMessage());

        return 1;
    }

    $this->info('Notifikasi test dikirim ke '.$email.'.');
    $this->line('Mailer aktif: '.config('mail.default'));

    return 0;
})->purpose('Send a CareerBridge notification test email');
