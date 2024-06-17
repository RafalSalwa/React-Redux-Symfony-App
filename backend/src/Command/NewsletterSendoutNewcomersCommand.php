<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\CryptonService;
use App\Service\UserService;
use DateTimeImmutable;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use function count;
use function sprintf;

#[AsCommand(name: 'newsletter:sendout:newcomers', description: 'Add a short description for your command')]
final class NewsletterSendoutNewcomersCommand extends Command
{
    private const DAYS_BACK_TO_CHECK = 7;

    public function __construct(
        private readonly UserService $userService,
        private readonly CryptonService $cryptonService,
        private readonly MailerInterface $mailer,
    ) {
        parent::__construct('newsletter:sendout:newcomers');
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Send newsletters for users registered in time period provided by user (default: 1 week)')
            ->addOption(
                'period',
                null,
                InputOption::VALUE_OPTIONAL,
                'No of days back to look for users',
                self::DAYS_BACK_TO_CHECK,
            )
        ;
    }

    /**
     * Currently we are skipping Sendout log since it's not required, It should be added in case of transport failure
     * and when we would like to reschedule sendout.
     *
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        $period = new DateTimeImmutable(sprintf('-%d days', $input->getOption('period')));
        $users = $this->userService->findActiveUsersCreatedSince($period);

        foreach ($users as $user) {
            $email = (new Email())
                ->from('cobbleweb@example.com')
                ->to($this->cryptonService->decrypt($user->getEmail()))
                ->subject('Your best newsletter')
                ->html(
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id interdum nibh.
                    Phasellus blandit tortor in cursus convallis. Praesent et tellus fermentum, pellentesque lectus at,
                    tincidunt risus. Quisque in nisl malesuada, aliquet nibh at, molestie libero.',
                );

            $this->mailer->send($email);
        }

        $symfonyStyle->success('Newsletter sent to ' . count($users) . ' users.');

        return Command::SUCCESS;
    }
}
