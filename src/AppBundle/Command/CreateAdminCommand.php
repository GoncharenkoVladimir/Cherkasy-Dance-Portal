<?php

namespace AppBundle\Command;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use AppBundle\Form\Registration;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:admin:create')
            ->setDescription('Create an admin user to the Admin Dashboard')
            ->addArgument('username', InputArgument::REQUIRED, 'username')
            ->addArgument('email', InputArgument::REQUIRED, 'email')
            ->addArgument('password', InputArgument::REQUIRED, 'password')
            ->addArgument('url', InputArgument::REQUIRED, 'url');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $plainPassword = $input->getArgument('password');
        $email = $input->getArgument('email');
        $url = $input->getArgument('url');

        $admin = new User();
        $form = $this->getContainer()->get('form.factory')->create(new Registration(), $admin, [
            'csrf_protection' => false,
            'validation_groups' => 'new'
        ]);
        $form->submit(['username' => $username, 'plainPassword' => $plainPassword, 'email' => $email, 'url' => $url]);

        if (!$form->isValid()) {
            $output->writeln('Incorrect data!!!');
            foreach($form->getErrors() as $error) {
                $output->writeln($error->getMessage());
            }
            return;
        }

        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        if ($em->getRepository('AppBundle:User')->findOneBy(['email' => $admin->getEmail()])) {
            $output->writeln('User are exist with input email!!!');

            return;
        }
        $admin->setRoles([User::ROLE_SUPER_ADMIN]);
        $encoder = $this->getContainer()->get('security.encoder_factory')->getEncoder($admin);
        $admin->setPassword($encoder->encodePassword( $admin->getPlainPassword(), $admin->getSalt()));
        $admin->setUrl('tttt.ttt.tt');

        $em->persist($admin);
        $em->flush();

        $output->writeln('User was created.');
    }
}
