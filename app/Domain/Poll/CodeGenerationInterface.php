<?php

namespace App\Domain\Poll;

interface CodeGenerationInterface
{
    public function generate(): string;
}
