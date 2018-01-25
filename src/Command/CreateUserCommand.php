<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 25/01/18
 * Time: 08:44
 */

namespace App\Command;

use App\Entity\User;
use App\Manager\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateUserCommand extends Command
{
    /** @var  UserManager */
    private $userManager;

    public function __construct(UserManager $userManager, $name = null)
    {
        $this->userManager = $userManager;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:user:create')

            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        // Username
        $question = new Question('Please enter the username: ');
        $username = $helper->ask($input, $output, $question);

        // Email
        $question = new Question('Please enter the email address: ');
        $email = $helper->ask($input, $output, $question);

        // Password
        $question = new Question('Please enter the password: ');
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        $password = $helper->ask($input, $output, $question);

        $user = new User();

        $user->setEmail($email);
        $user->setUsername($username);
        $user->setPassword($password);

        $this->userManager->updateUserPassword($user);
        $this->userManager->updateUser($user, true);

    }
}
