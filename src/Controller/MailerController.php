<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    public MailerInterface $mailer;
    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }
    #[Route('/mailer', name: 'app_mailer')]
    public function index(): Response
    {
        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    #[Route('/email')]
    public function sendEmail() :Response
    {
        $email = (new Email())
            ->from("annakotelnikova4@gmail.com")
            ->to("annakotelnikova4@gmail.com")
            ->subject('Fruit table was saved correctly')
            ->text('Fruit table was saved correctly')
            ->html('<p>Fruit table was saved correctly</p>');

        $this->mailer->send($email);
        return new Response("Email was sent");
    }
}
