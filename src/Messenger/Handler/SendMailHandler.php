<?php

namespace App\Messenger\Handler;

use App\Messenger\Command\SendMailCommand;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

class SendMailHandler implements MessageHandlerInterface
{

    /** @var MailerInterface */
    private $mailer;

    /**
     * SendMailHandler constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param SendMailCommand $message
     */
    public function __invoke(SendMailCommand $message)
    {
        try {

            $email = new Email();
            $email->from('hello@example.com')
                ->to($message->getEmail())
                ->subject('Just test')
                ->text($message->getMessage());

            $this->mailer->send($email);

        } catch (TransportExceptionInterface $e) {
            throw new UnrecoverableMessageHandlingException('Mail not sent');
        }
    }
}
