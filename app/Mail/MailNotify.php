<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;
    public $messageContent;
    public $title;
    public $senderName;
    public $senderEmail;
    public $bookOrderDetails;
    public $totalPrice;

    /**
     * Constructor to initialize email content and order details
     *
     * @param string $messageContent Content of the message
     * @param string $title Title of the email
     * @param array $bookOrderDetails Details of the book order
     * @param float $totalPrice Total price of the order
     */
    public function __construct($messageContent, $title, $bookOrderDetails,$totalPrice)
    {
        $this->messageContent = $messageContent;
        $this->title = $title;
        $this->senderName = "BookStore";
        $this->senderEmail = "gietconheo88@gmail.com";
        $this->bookOrderDetails = $bookOrderDetails;
        $this->totalPrice = $totalPrice;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $htmlContent = '<p>Total price of the order is: ' . $this->totalPrice . '</p>' . '<p>' . $this->messageContent . '</p>';
        $htmlContent .= '<table border="1" cellpadding="5" cellspacing="0">';
        $htmlContent .= '<thead><tr><th>Book ID</th><th>Title</th><th>Quantity</th><th>Price</th></tr></thead>';
        $htmlContent .= '<tbody>';
        foreach ($this->bookOrderDetails as $detail) {
            $htmlContent .= '<tr>';
            $htmlContent .= '<td>' . $detail['book_id'] . '</td>';
            $htmlContent .= '<td>' . $detail['title'] . '</td>'; 
            $htmlContent .= '<td>' . $detail['quantity'] . '</td>';
            $htmlContent .= '<td>' . $detail['price'] . '</td>';
            $htmlContent .= '</tr>';
        }
        $htmlContent .= '</tbody></table>';
        return $this->from($this->senderEmail, $this->senderName)
                    ->subject($this->title)
                    ->html($htmlContent);
    }
}
