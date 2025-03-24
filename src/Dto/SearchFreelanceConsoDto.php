<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class SearchFreelanceConsoDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'La requête ne doit pas être vide.')]
        #[Assert\Length(
            min: 3,
            minMessage: 'La requête doit comporter au moins {{ limit }} caractères.'
        )]
        public string $query
    )
    {
    }
}