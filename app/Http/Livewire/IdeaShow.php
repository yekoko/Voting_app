<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;
use App\Exceptions\VoteNotFoundException;
use App\Exceptions\DuplicateVoteException;

class IdeaShow extends Component
{
    public $idea;
    public $voteCount;
    public $hasVoted;

    public function mount(Idea $idea, $voteCount)
    {
        $this->idea = $idea;
        $this->voteCount = $voteCount;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
    }

    public function vote()
    {
        if (! auth()->check()) {
            return redirect(route('login'));
        }

        if ($this->hasVoted) {
            try {
                $this->idea->remove_vote(auth()->user());
                
            } catch (VoteNotFoundException $e) {
                
            }
            $this->voteCount--;
            $this->hasVoted = false;
        }else{
            try {
                $this->idea->vote(auth()->user());
            } catch (DuplicateVoteException $e) {
                
            }
            
            $this->voteCount++;
            $this->hasVoted = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
