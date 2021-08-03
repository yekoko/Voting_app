<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Response;
use App\Models\Idea;

class SetStatus extends Component
{
    public $idea;
    public $status;


    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        $this->status = $this->idea->status_id;
    }


    public function render()
    {
        return view('livewire.set-status');
    }

    public function setStatus()
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->idea->status_id = $this->status;
        $this->idea->save();

        $this->emit('statusWasUpdated');
    }
}
