<?php
namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    /**
     * UserFixtures constructor.
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setFirstname("Paz");
        $admin->setLastname("Pok");
        $admin->setEmail("mathieu.legal@live.fr");
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, "mlegal"));
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, "1234"));
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
            $this->addReference('user-' . ($i + 1), $user);
        }
        $manager->flush();
    }
}