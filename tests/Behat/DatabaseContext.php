<?php

namespace App\Tests\Behat;

use App\Domain\Entity\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;

final class DatabaseContext implements Context
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @BeforeScenario
     *
     * @throws ToolsException
     */
    public function setUpDatabase(): void
    {
        $schemaTool = new SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropSchema($classes);
        $schemaTool->createSchema($classes);

        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
    }

    /**
     * @Given /^the following user exist:$/
     */
    public function theFollowingUserExist(TableNode $table): void
    {
        foreach ($table->getHash() as $userData) {
            $user = new User();
            $user->setName($userData['name']);
            $user->setEmail($userData['email']);

            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();
    }
}
