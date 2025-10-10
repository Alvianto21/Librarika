<?php

namespace App\Notifications;

use App\Models\Borrow;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RejectedBorrow extends Notification
{
    use Queueable;

    protected Borrow $borrow;

    /**
     * Create a new notification instance.
     */
    public function __construct(Borrow $borrow)
    {
        $this->borrow = $borrow;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Peminjaman Buku Ditolak')
                    ->greeting('Halo, ' . $notifiable->nama)
                    ->line('Kami mohon maaf bahwa permintaan peminjaman buku berjudul '. $this->borrow->book->judul . ' dengan kode pinjam ' . $this->borrow->kode_pinjam . ' telah ditolak.')
                    ->line('Anda dapat mengajukan peminjaman lain dengan buku yang sama atau dengan buku yang baru.')
                    ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
