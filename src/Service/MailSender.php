<?php
namespace App\Service;

use App\Entity\User;

class MailSender
{
    const ACTIVATION_SUBJECT = "Activation de votre compte AtypikHouse";
    const PASSWORD_RESET_REQUEST_SUBJECT = "Réinitialisation du mot de passe de votre compte AtypikHouse";
    const RESERVATION_ANNONCE = "Reservation enregistrée !";
    const RESERVATION_ANNONCE_CANCELLED = "Votre réservation a bien été annulée.";

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, $rootpath)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->rootpath = $rootpath;
    }

    public function sendActivationEmail(User $user, string $token)
    {
        $template = "activation.email.twig";
        $context =[
            "user" => $user,
            "token" => $token
        ];

        $this->sendEmail($template, $context, self::ACTIVATION_SUBJECT ,$user->getEmail());
    }

    public function sendPasswordRequestEmail(User $user, string $token)
    {
        $template = "password_reset_request.email.twig";
        $context =[
            "token" => $token
        ];

        $this->sendEmail($template, $context, self::PASSWORD_RESET_REQUEST_SUBJECT, $user->getEmail());
    }

    public function sendReservationNotificationEmail($reservation, $owner)
    {
        $template = "reservation_annonce.email.twig";
        $context = [
            "reservation"=>$reservation
        ];
        $this->sendEmail($template, $context, self::RESERVATION_ANNONCE, $owner->getEmail());
    }

    public function sendReservationCancellingNotificationEmail($reservation, $owner)
    {
        $template = "reservation_annonce_cancelled.email.twig";
        $context = [
            "reservation"=>$reservation
        ];
        $this->sendEmail($template, $context, self::RESERVATION_ANNONCE_CANCELLED, $owner->getEmail());
    }

    private function sendEmail(string $templateName, array $context, string $subject, string $toEmail)
    {

        $template = $this->twig->loadTemplate($templateName);
        $subject = $template->renderBlock('subject', ['subject'=>$subject]);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('html_text', $context);
        $message = (new \Swift_Message($subject))
            ->setFrom('no-reply@atypik.house')
            ->setTo($toEmail)
            ;

        if(!empty($htmlBody))
        {
            $message->setBody($htmlBody, 'text/html')->addPart($textBody, 'text/plain');
        }
        else
        {
            $message->setBody($textBody);
        }

        $this->mailer->send($message);
    }

}