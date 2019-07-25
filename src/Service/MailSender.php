<?php


namespace App\Service;


use App\Entity\User;

class MailSender
{
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

        $this->sendEmail($template, $context, $user->getEmail());
    }

    public function sendPasswordRequestEmail(User $user, string $token)
    {
        $template = "password_reset_request.email.twig";
        $context =[
            "token" => $token
        ];

        $this->sendEmail($template, $context, $user->getEmail());
    }

    private function sendEmail($templateName, $context, $toEmail)
    {
        $message = (new \Swift_Message("test"))
            ->setFrom('deozza@gmail.com')
            ->setTo($toEmail)
            ->setBody(
                $this->twig->render($templateName, $context)
            );

        $this->mailer->send($message);
    }

}