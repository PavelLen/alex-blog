<?php

namespace Abuchyn\AlexBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints as Assert;

class Enquiry
{

    protected $name;

    protected $email;

    protected $subject;

    protected $body;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new NotBlank(array(
            'message' => 'Поле "Имя" не должно быть пустым!'
        )));
        $metadata->addPropertyConstraints('email', [
            new Email(array(
                'message' => 'Не корретно заполнено поле "email"!'
            )),
            new NotBlank(array(
                'message' => 'Поле "Email" не должно быть пустым!'
            ))
        ]);

        $metadata->addPropertyConstraints('subject', [
            new Length(array(
                'max'        => 50,
                'maxMessage' => 'Не корретно заполнено поле "Тема"! Максимальное количество символов {{ limit }}'
            )),
            new NotBlank(array(
                'message' => 'Поле "Тема" не должно быть пустым!'
            ))
        ]);

        $metadata->addPropertyConstraints('body', [
            new Length(array(
                'min'        => 50,
                'minMessage' => 'Не корретно заполнено поле Сообщение! Сообщение должно состоять минимум из {{ limit }} символов'
            )),
            new NotBlank(array(
                'message' => 'Поле "Сообщение" не должно быть пустым!'
            ))
        ]);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }


}