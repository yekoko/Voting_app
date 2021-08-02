<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;
use App\Models\Vote;
use Livewire\WithPagination;
use App\Models\Status;
use App\Models\Category;

class IdeasIndex extends Component
{
    use WithPagination;

    public $status;
    public $category;

    protected $queryString = [
        'status',
        'category'
    ];

    protected $listeners = ['queryStringUpdatedStatus'];

    public function mount()
    {
        $this->status = request()->status ?? 'All';
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function queryStringUpdatedStatus($newStatus)
    {
        $this->resetPage();

        $this->status = $newStatus;
    }

    public function render()
    {
        $statuses = Status::all()->pluck('id', 'name');

        $categories = Category::all();

        $ideas = Idea::with('user','category','status')
            ->when($this->status && $this->status !== 'All', function ($query) use ($statuses) {
                return $query->where('status_id', $statuses->get($this->status));
            })
            ->when($this->category && $this->category !== 'All Categories', function ($query) use ($categories) {
                return $query->where('category_id', $categories->pluck('id', 'name')->get($this->category));
            })
            ->addSelect([
                'voted_by_user' => Vote::select('id')
                    ->where('user_id', auth()->id())
                    ->whereColumn('idea_id', 'ideas.id')
            ])
            ->withCount('votes')
            ->orderBy('id','desc')
            ->simplePaginate();

        return view('livewire.ideas-index',compact('ideas','categories'));
    }
}
