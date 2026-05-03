<?php

namespace App\Domain\Poll;

use App\Models\Poll;

class PollFactory
{
    protected $strategy;

    public function __construct(CodeGenerationInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function create(string $title, array $options): Poll
    {
        $poll = Poll::create([
            'title' => $title,
            'short_code' => $this->strategy->generate()
        ]);

        foreach ($options as $optionText) {
            $poll->options()->create(['text' => $optionText]);
        }

        return $poll;
    }
}
