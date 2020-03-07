<?php

namespace App\Util;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Mime\Email;
use SymfonyBundles\KafkaBundle\Command\Consumer;

class KafkaEmailConsumer extends Consumer implements KafkaEmailConsumerInterface
{
    public const QUEUE_NAME = 'email_send_queue';

    /** @var MailerInterface */
    private $mailer;

    /**
     * @required
     * @param MailerInterface $mailer
     */
    public function setMailer(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * {@inheritdoc}
     */
    protected function onMessage(array $data): void
    {
        try {

            $email = new Email();
            $email->from('hello@example.com')
                ->to($data['email'])
                ->subject('Just test')
                ->text($data['message'] . PHP_EOL . print_r($data, 1));

            $this->mailer->send($email);

        } catch (TransportExceptionInterface $e) {
            throw new UnrecoverableMessageHandlingException('Mail not sent');
        }
    }
}
