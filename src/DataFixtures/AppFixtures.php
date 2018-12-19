<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    private $roles = [
        'ROLE_PREMIUM',
        'ROLE_WRITER',
        'ROLE_ADMIN'
    ];
    private $themes = [

    ];

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        foreach ($this->roles as $key => $roleName) {
            $randomRole = new Role();
            $randomRole->setRoleName($roleName);
            $manager->persist($randomRole);
        }



        $julie = new User();
        $julie->setPseudo('juju')
                ->setHash($this->encoder->encodePassword($julie, 'password'))
                ->setMail('julie@hotmail.fr')
                ->setAvatar('https://randomuser.me/api/portraits/women/54.jpg')
                ->setDescription($faker->sentence(20, true))
                ->addUserRole($randomRole->setRoleName('ROLE_ADMIN'));
        $manager->persist($julie);

        $etienne = new User();
        $etienne->setPseudo('tinou')
            ->setHash($this->encoder->encodePassword($etienne, 'password'))
            ->setMail('tinou@hotmail.fr')
            ->setAvatar('https://randomuser.me/api/portraits/men/54.jpg')
            ->setDescription($faker->sentence(20, true))
            ->addUserRole($randomRole->setRoleName('ROLE_WRITER'));
        $manager->persist($etienne);

        $randomUsers[] = new User();
        $genres = ['male', 'female'];
        for ($i = 1; $i <= 30; $i++) {
            $randomUser = new User();

            $genre = $faker->randomElement($genres);
            $avatar = "https://randomuser.me/api/portraits/";
            $avatarId = $faker->numberBetween(1, 99). '.jpg';

            $avatar .= ($genre == 'male' ? 'men/' : 'women/').$avatarId;
            $hash = $this->encoder->encodePassword($randomUser, 'password');

            $randomUser->setPseudo($faker->firstName($genre))
                ->setHash($hash)
                ->setMail($faker->email)
                ->setAvatar($avatar)
                ->setDescription($faker->sentence(20, true))
                ->addUserRole($randomRole->setRoleName($faker->randomElement($this->roles)));

            $manager->persist($randomUser);
            $randomUsers[] = $randomUser;
        }

        $manager->flush();
    }
}
