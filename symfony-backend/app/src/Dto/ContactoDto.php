<?php
namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;
class ContactoDto
{
    public function __construct(
        #[Assert\NotBlank (message : 'El campo nombre está vacio')]
        #[Assert\Type ('string')]
        public readonly string $name,

        #[Assert\NotBlank (message : 'El campo E-mail está vacio')]
        #[Assert\Email (message : 'El E-mail no tiene un formato válido')]
        public readonly string $email,
        
        #[Assert\NotBlank (message : 'El campo telefono está vacio')]
        #[Assert\Type ('string')]
        public readonly string $telefono,

        #[Assert\NotBlank (message : 'El campo mensaje está vacio')]
        #[Assert\Type ('string')]
        public readonly string $mensaje
    ) 
    {}
        
    
}