<?php

namespace App\Notifications;

use App\Models\Borrow;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorrowAgreement extends Notification
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
                    ->subject('Peminjaman Buku Disetujui')
                    ->greeting('Halo ' . $notifiable->nama . ',')
                    ->line('Permintaan peminjaman buku ' . $this->borrow->book->judul . ' dengan kode pinjam ' . $this->borrow->kode_pinjam . ' telah disetujui.')
                    ->line('Tanggal Pinjam: '. Carbon::parse($this->borrow->tgl_pinjam))
                    ->line('Anda dapat mengambil buku tersebut ke perpustakawan kami.')
                    ->line('Durasi peminjmana buku adalah 3 minggu setelah anda menngambil buku')
                    ->action('Lihat detai Peminjaman', route('users.borrow.info', ['borrow' => $this->borrow->kode_pinjam]))
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
