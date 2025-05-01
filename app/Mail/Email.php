<?php

namespace App\Mail;



use Illuminate\Bus\Queueable;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Mail;

class Email extends Mailable
{
    use Queueable, SerializesModels;
    public $donnée;
    /**
     * Create a new message instance.
     */
    public function __construct($donnée)
    {
        // S'assurer que "image" est bien un tableau
        $this->donnée = $donnée;
    }


    /**
     * Create a new message instance.
     */
    // public function __construct() {}

    public function build()
    {
        return $this->view('mail.email') // La vue de l'email
            ->with([
                'formulaire' => $this->donnée,
            ]);
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('projet-php@qwesty.be', 'Nouveau Mail'),
            subject: 'Cure',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.email',
        );
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


// if ($etudiants_email->isNotEmpty() && $formulaire && $professeurs) {

//     foreach ($etudiants_email as $key => $email) {
//         // recup email
//         // voir si trim()

//         Mail::to($email->email)->send(new Email($formulaire));
//     }
//     Course::where('id', $id)->update([
//         'is_envoyer' => true,
//     ]);

//     return back()->banner("reussi");
// } else {
//     return redirect()->back()->withErrors(
//         [
//             'id' => $id,
//             'error' => "Il manque une donnée parmi les suivantes : " .
//                 ($etudiants_email->isEmpty() ? "Étudiant(s) manquant " : "") . " / " .
//                 (!$formulaire ? "Formulaire manquant" : "") . " / " . (!$professeurs ? "Professeur manquant" : ""),

//         ]

//     );
// }
