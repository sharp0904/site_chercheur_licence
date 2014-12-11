<?php

namespace Appli;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class PasswordEncoder
{
    private $encoder;
    private $salt;

    public function __construct()
    {
        $this->encoder = new MessageDigestPasswordEncoder();
        $this->salt = 'A654FSDFSD54FDSF45D$SFSD4FDS5£';
    }

    public function encodePassword($password)
    {
        return $this->encoder->encodePassword($password, $this->salt);
    }

    public function verifyPassword($encodedPassword, $userPassword)
    {
        return $this->encoder->isPasswordValid($encodedPassword, $userPassword, $this->salt);
    }
}
