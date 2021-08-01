<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;

class IdeaShow extends Component
{
    public $idea;
    public $voteCount;

    public function mount(Idea $idea, $voteCount)
    {
        $this->idea = $idea;
        $this->voteCount = $voteCount;
    }


    public function render()
    {
        return view('livewire.idea-show');
    }
}
