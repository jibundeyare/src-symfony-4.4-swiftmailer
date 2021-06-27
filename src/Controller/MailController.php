<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function index(\Swift_Mailer $mailer): Response
    {
        // Email du destinataire
        $toEmail = 'bar.baz@example.com';

        // Choix du sujet du mail
        $message = (new \Swift_Message('Hello Swiftmailer!'))
            // Choix de l'adresse de l'expéditeur
            // Même si mettez une adresse "from" différente du compte SMTP,
            // l'adresse du compte SMTP sera visible dans l'entête du mail
            ->setFrom(['foo.bar@example.com' => 'Foo Bar'])
            // Choix de l'adresse du destinataire
            ->setTo([$toEmail])
            // Choix du message au format HTML
            ->setBody(
                $this->renderView('emails/hello.html.twig', [
                    'toEmail' => $toEmail
                ]),
                'text/html'
            )
            // Choix du message au format texte
            ->addPart(
                $this->renderView('emails/hello.txt.twig', [
                    'toEmail' => $toEmail
                ]),
                'text/plain'
            )
        ;

        $mailer->send($message);

        return $this->json([
            'message' => 'Email envoyé',
            'path' => 'src/Controller/MailController.php',
        ]);
    }
}
