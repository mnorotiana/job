<?php
namespace UserBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

class UserFixtures implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Get our userManager, you must implement `ContainerAwareInterface`
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('administrator@jobfinder.com');
        $user->setPlainPassword('WkSfc3zC9E,qt-7');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setNom("Administrator");
        $user->setAdresse("DGPE");
        $user->setTelephone("0000000000");
        // Update the user
        $manager->persist($user);
        $manager->flush();
    }
}
?>