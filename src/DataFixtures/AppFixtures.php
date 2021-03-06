<?php
/**
 * Created by PhpStorm.
 * User: ladam
 * Date: 2/17/2019
 * Time: 6:34 PM
 */

namespace App\DataFixtures;


use App\Entity\BlogPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface $passwordEncoder
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
    }


    public function loadBlogPosts(ObjectManager $manager)
    {
        $user = $this->getReference('user_admin');

        $blogPost = new BlogPost();
        $blogPost->setTitle("A first post!");
        $blogPost->setAuthor($user);
        $blogPost->setPublished(new \DateTime('2019-02-17 12:00:00'));
        $blogPost->setContent('Post text!');
        $blogPost->setSlug('a-first-post');

        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setAuthor($user);
        $blogPost->setTitle("A second post!");
        $blogPost->setPublished(new \DateTime('2019-02-17 12:00:00'));
        $blogPost->setContent('Post text!');
        $blogPost->setSlug('a-second-post');

        $manager->persist($blogPost);

        $manager->flush();
    }

    public function loadComments()
    {

    }

    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@blog.com');
        $user->setName('Larry A');

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'secret123#'
        ));

        $this->addReference('user_admin', $user);

        $manager->persist($user);
        $manager->flush();
    }

}