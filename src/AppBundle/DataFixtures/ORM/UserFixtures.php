<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Defines the sample users to load in the database before running the unit and
 * functional tests. Execute this command to load the data.
 *
 *   $ php bin/console doctrine:fixtures:load
 *
 * See https://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class UserFixtures extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $Admin = new User();
        $Admin->setFullName('Funpar');
        $Admin->setUsername('admin');
        $Admin->setEmail('admin@exemplo.com');
        $Admin->setRoles(['ROLE_ADMIN']);
        $encodedPassword = $passwordEncoder->encodePassword($Admin, 'Pesquisa@2017');
        $Admin->setPassword($encodedPassword);
        $manager->persist($Admin);
        $this->addReference('funpar-admin', $Admin);

        $User = new User();
        $User->setFullName('Equipe Funpar');
        $User->setUsername('user');
        $User->setEmail('user@exemplo.com');
        $encodedPassword = $passwordEncoder->encodePassword($User, 'Pesquisa@2017');
        $User->setPassword($encodedPassword);
        $manager->persist($User);
        $this->addReference('funpar-user', $User);

        $manager->flush();
    }
}
