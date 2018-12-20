<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Localisation;
use App\Entity\Role;
use App\Entity\Support;
use App\Entity\Tag;
use App\Entity\Theme;
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
        'Politique',
        'Economie',
        'Culture',
        'Santé',
        'Histoire',
        'Société',
        'International',
        'Education',
        'Environnement',
        'Loisirs',
        'Sport',
        'Journalisme'
    ];
    private $tags = [
        'Addictions',
        'Agriculture',
        'Art contemporain',
        'Cigarettes',
        'Consommation',
        'Communication',
        'Football',
        'Indonésie',
        'Lait',
        'Pollution',
        'Strasbourg'
    ];
    private $supports = [
        'Article',
        'Vidéo',
        'Podcast',
        'LIVE!'
    ];

    private $localisation;

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

        foreach ($this->themes as $key => $themeName) {
            $theme = new Theme();
            $theme->setThemeName($themeName);
            $manager->persist($theme);
        }

        foreach ($this->tags as $key => $tagName) {
            $tag = new Tag();
            $tag->setTagName($tagName);
            $manager->persist($tag);
        }

        foreach ($this->supports as $key => $supportName) {
            $support = new Support();
            $support->setMedia($supportName);
            $manager->persist($support);
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

        $localisations = [];
        for ($j = 1; $j <= 20; $j++) {
            $location = new Localisation();
            $location->setLocationName($faker->city);
            $manager->persist($location);
            $localisations[] = $location;
        }

//        for ($j = 1; $i <= 100; $i++) {
//            $article = new Articles();
//            $user = $randomUsers[mt_rand(0, count($randomUsers) - 1)];
//
//            $article->setTitle($faker->sentence())
//                    ->setContent($faker->sentence($faker->numberBetween(5, 20), true). ' '.
//                        $faker->sentence($faker->numberBetween(5, 20), true). ' '.
//                        $faker->sentence($faker->numberBetween(5, 20), true). ' '.
//                        $faker->sentence($faker->numberBetween(5, 20), true). ' '.
//                        $faker->sentence($faker->numberBetween(5, 20), true). ' '.
//                        $faker->sentence($faker->numberBetween(5, 20), true). ' '.
//                        $faker->sentence($faker->numberBetween(5, 20), true). ' '.
//                        $faker->sentence($faker->numberBetween(5, 20), true). ' '.
//                        $faker->sentence($faker->numberBetween(5, 20), true). ' '.
//                        $faker->sentence($faker->numberBetween(5, 20), true). ' '.
//                        $faker->sentence($faker->numberBetween(5, 20), true))
//                    ->addAuthor($user)
//                    ->addTheme($theme)
//                    ->addTag($tag)
//                    ->setDate($faker->dateTime('now'))
//                    ->setHeadPicture($faker->imageUrl(1200, 300));
//            $manager->persist($article);
//            }

        $manager->flush();
    }
}
