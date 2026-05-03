<?php

namespace App\Http\Controllers;

use App\Domain\Poll\PollFactory;
use App\Domain\Poll\CodeGeneration;
use App\Http\Requests\CreatePollRequest;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PollController extends Controller
{
    private function getPollResponse(Poll $poll, $hasVoted = false): JsonResponse
    {
        $response = [
            'title' => $poll->title,
            'options' => $this->formatOptions($poll),
        ];

        if ($hasVoted) {
            $response['hasVoted'] = true;
            $response['results'] = $this->formatResults($poll);
        } else {
            $response['hasVoted'] = false;
        }

        return response()->json($response);
    }

    private function formatOptions(Poll $poll): array
    {
        $result = [];
        foreach ($poll->options as $opt) {
            $result[] = [
                'id' => $opt->id,
                'text' => $opt->text,
            ];
        }

        return $result;
    }

    private function formatResults(Poll $poll): array
    {
        $options = $poll->options()->withCount('votes')->get();
        $result = [];
        foreach ($options as $opt) {
            $result[] = [
                'option' => $opt->text,
                'count' => $opt->votes_count,
            ];
        }

        return $result;
    }

    public function store(CreatePollRequest $request): JsonResponse
    {
        $validated = $request->validated();

        //  Использование Фабрики со стратегией 
        $poll = (new PollFactory(new CodeGeneration))->create($validated['title'], $validated['options']);

        return response()->json(['short_code' => $poll->short_code]);
    }

    public function show(Request $request, $shortCode): JsonResponse
    {
        $poll = Poll::with('options')->where('short_code', $shortCode)->firstOrFail();

        $hasVoted = Vote::where('poll_id', $poll->id)
            ->where('ip_address', $request->ip())
            ->exists();

        return $this->getPollResponse($poll, $hasVoted);
    }

    public function vote(Request $request, $shortCode): JsonResponse
    {
        $request->validate(['option_id' => 'required|exists:options,id']);

        $poll = Poll::where('short_code', $shortCode)->firstOrFail();

        if (Vote::where('poll_id', $poll->id)
            ->where('ip_address', $request->ip())
            ->exists()
        ) {
            return response()->json(['message' => 'Вы уже голосовали'], 409);
        }

        $poll->votes()->create([
            'option_id' => $request->input('option_id'),
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['votes' => $this->formatResults($poll)]);
    }
}
