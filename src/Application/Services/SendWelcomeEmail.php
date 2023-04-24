<?php

namespace App\Application\Services;

use App\Application\Dto\Input\UserInputDto;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Translation\TranslatorInterface;

final class SendWelcomeEmail
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function send(UserInputDto $dto): void
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to($dto->email)
            ->subject($this->translator->trans('email.welcome', ['name' => $dto->name]))
            ->text($this->translator->trans('email.welcome', ['name' => $dto->name]))
        ;

        $this->mailer->send($email);
    }
}
