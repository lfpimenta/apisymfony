<?php

namespace App\Test\Tests\Business;


use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ManagedUser extends KernelTestCase
{
    /**
     * @var User
     */
    protected $instance;

    public function setUp()
    {
        self::bootKernel();
        $dc = self::$kernel->getContainer()->get('doctrine');
        $this->instance = new \App\Business\ManagedUser($dc);
    }

    public function testList() {
        //$dc = self::$kernel->getContainer()->get('doctrine');
        //$instance = new \App\Business\ManagedUser($dc);

        for ($i = 0; $i <10; $i++) {
            $record = $this->instance->findBy(['Name' => 'User  ' . $i]);
            $this->assertInstanceOf('App\Entity\User', $record[0]);
        }
    }

    public function testShow() {
        $nameUser = 'User  2';
        $firstRecord = $this->instance->findBy(['Name' => $nameUser]);
        $id = $firstRecord[0]->getId();
        $admin = $firstRecord[0]->getAdmin();

        $record = $this->instance->show($id);

        $this->assertEquals($nameUser, $record['name']);
        $this->assertEquals($admin, $record['admin']);
        $this->assertEquals(['id', 'name', 'admin'],array_keys($record));
    }

    // Cannot delete user because it is on a group
    public function testDeleteException() {
        $nameUser = 'User  2';
        $firstRecord = $this->instance->findBy(['Name' => $nameUser]);
        $id = $firstRecord[0]->getId();

        $this->expectException(ORMException::class);// User is present in group)
        $this->instance->deleteRecord($id);
    }


    public function testDelete() {
        $nameUser = 'User  9';
        $firstRecord = $this->instance->findBy(['Name' => $nameUser]);
        $id = $firstRecord[0]->getId();
        $this->instance->deleteRecord($id);

        $firstRecord = $this->instance->findBy(['Name' => $nameUser]);
        $this->assertEmpty($firstRecord);
    }

}