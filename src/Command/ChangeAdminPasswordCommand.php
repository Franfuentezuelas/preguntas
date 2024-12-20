<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ChangeAdminPasswordCommand extends Command
{
    // Nombre del comando
    protected static $defaultName = 'app:nuevo-password-admin';

    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    // Configurar el comando (nombre, descripción, argumentos)
    protected function configure(): void
    {
        $this
            ->setName('app:nuevo-password-admin') // Define el nombre aquí
            ->setDescription('Cambia la contraseña del administrador')
            ->addArgument('newPassword', InputArgument::REQUIRED, 'La nueva contraseña para el administrador');
    }

    // Ejecutar el comando
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $newPassword = $input->getArgument('newPassword');

        // Buscar al usuario con el rol 'ROLE_ADMIN'
        $user = $this->entityManager->createQueryBuilder()
                                    ->select('u')
                                    ->from(User::class, 'u')
                                    ->where('u.roles LIKE :role')
                                    ->setParameter('role', '%ROLE_ADMIN%')
                                    ->getQuery()
                                    ->getOneOrNullResult();

        if (!$user) {
            $io->error('No se encontró ningún usuario con el rol "ROLE_ADMIN".');
            return Command::FAILURE;
        }

        // Codificar la nueva contraseña
        $encodedPassword = $this->passwordHasher->hashPassword($user, $newPassword);
        $user->setPassword($encodedPassword);

        // Guardar los cambios en la base de datos
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('La contraseña del administrador se ha cambiado exitosamente.');
        return Command::SUCCESS;
    }
}
