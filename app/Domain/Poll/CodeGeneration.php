<?php

namespace App\Domain\Poll;

use App\Models\Poll;

class CodeGeneration implements CodeGenerationInterface
{
    public function generate(): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $chars = str_replace(['0', 'O', 'l', 'I'], '', $chars);

        do {
            $code = substr(str_shuffle($chars), 0, 6);
        } while (Poll::where('short_code', $code)->exists());

        return $code;
    }
}
