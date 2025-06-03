<?php
namespace App\Dto;
use Symfony\component\Validator\Constraints as Assert;
class LoginDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'El campo E-mail está vacio')]
        #[Assert\Email(message: 'El E-mail ingresado no tiene formato válido')]
        public readonly string $email,
        
        #[Assert\NotBlank(message:'El campo password está vacio')]
        public readonly string $password
    ){
        
    }
}