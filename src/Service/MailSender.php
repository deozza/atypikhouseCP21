<?php
namespace App\Service;

use App\Entity\User;

class MailSender
{
    const ACTIVATION_SUBJECT = "Activation de votre compte AtypikHouse";
    const PASSWORD_RESET_REQUEST_SUBJECT = "Réinitialisation du mot de passe de votre compte AtypikHouse";

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

    private function sendEmail(string $templateName, array $context, string $subject, string $toEmail)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom('deozza@gmail.com')
            ->setTo($toEmail)
            ->setBody(
                $this->twig->render($templateName, $context)
            );

        $this->mailer->send($message);
    }

}