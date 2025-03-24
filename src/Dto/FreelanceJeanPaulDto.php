<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class FreelanceJeanPaulDto
{
        #[Assert\NotBlank]
        #[Assert\NotNull]
        #[Assert\Type('string')]
        public string $firstName;
        
        #[Assert\NotBlank]
        #[Assert\NotNull]
        #[Assert\Type('string')]
        public string $lastName;

        #[Assert\NotBlank]
        #[Assert\NotNull]
        #[Assert\Type('string')]
        public string $jobTitle;

        #[Assert\Type('integer')]
        public int $jeanPaulId;
        
        public function __construct(string $firstName, string $lastName, string $jobTitle, int $jeanPaulId)
        {
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->jobTitle = $jobTitle;
            $this->jeanPaulId = $jeanPaulId;
        }
    
}