<?php 
namespace App\Core;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class EmailSender {

    private $transport;
    private $mailer;

    function __construct() {
        $this->transport = Transport::fromDsn($_ENV['SMTP_SERVER']);
        $this->transport->setUsername($_ENV['SMTP_USER']);
        $this->transport->setPassword($_ENV['SMTP_PASSWORD']);
        $this->mailer = new Mailer($this->transport);
    }

    public function sendConfirmationMail($name, $surname, $email, $token) {
        $email = (new Email())
            ->from('porfoliocreaciones@gmail.com')
            ->to($email)
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Bienvenido al porfolio de Creaciones!')
            // ->text('')
            ->html('<p>Para poder loguearte en el porfolio de Creaciones, necesitamos que valides tu correo. Date prisa, tienes 24 horas!</p><br><a href="http://portfolio.local/verificar/'.$token.'">VALIDA TU CORREO</a>');

        $this->mailer->send($email);
    }
}
