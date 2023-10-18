<?php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{

    /**
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private ?string $id = null;

    /**
     *
     * @ORM\Column()
     */
    private string $email;

    /**
     *
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     *
     * @param array $roles
     * @return self
     */
    public function setRoles($roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Symfony\Component\Security\Core\User\UserInterface::getPassword()
     */
    public function getPassword(): string
    {
        return '';
    }

    /**
     *
     * @param string $password
     */
    public function setPassword($password)
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Symfony\Component\Security\Core\User\UserInterface::getSalt()
     */
    public function getSalt()
    {
        return null;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Symfony\Component\Security\Core\User\UserInterface::getUserIdentifier()
     */
    public function getUserIdentifier()
    {
        return $this->getEmail();
    }

    /**
     *
     * {@inheritdoc}
     * @see \Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
     */
    public function eraseCredentials()
    {}

    /**
     *
     * {@inheritdoc}
     * @see \Symfony\Component\Security\Core\User\UserInterface::getUsername()
     */
    public function getUsername()
    {
        return $this->getUserIdentifier();
    }
}
