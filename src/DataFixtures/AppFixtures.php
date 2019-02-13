<?php

namespace App\DataFixtures;

use App\Entity\Groups;
use App\Entity\User;
use App\Entity\UserGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $users = [];


        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setName('User  '.$i);
            $user->setAdmin(mt_rand(0, 1));
            $user->setPassword('test_pass' . $i);
            $manager->persist($user);
            $users[] = $user;
        }

        $groups=[];

        for ($i = 0; $i < 5; $i++) {
            $group = new Groups();
            $group->setName('Group  ' . $i);
            $manager->persist($group);
            $groups[] = $group;
        }

        $groupUser= new UserGroup();
        $groupUser->setUserid($users[1]);
        $groupUser->setGroupid($groups[1]);
        $manager->persist($groupUser);

        $groupUser= new UserGroup();
        $groupUser->setUserid($users[2]);
        $groupUser->setGroupid($groups[1]);
        $manager->persist($groupUser);

        $groupUser= new UserGroup();
        $groupUser->setUserid($users[3]);
        $groupUser->setGroupid($groups[1]);
        $manager->persist($groupUser);

        $groupUser= new UserGroup();
        $groupUser->setUserid($users[10]);
        $groupUser->setGroupid($groups[4]);
        $manager->persist($groupUser);

        $manager->flush();
    }
}
