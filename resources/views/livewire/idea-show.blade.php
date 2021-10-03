<div class="idea-and-buttons container">
    <div class="ideas-container bg-white rounded-xl flex mt-4">
        <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
            <div class="flex-none mx-2 md:mx-0">
                <a href="#" >
                <img src="{{ $idea->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
            </div>
            <div class="w-full mx-2 md:mx-4">
                <h4 class="text-xl font-semibold mt-2 md:mt-0">
                   {{ $idea->title }}
                </h4>
                <div class="text-gray-600 mt-3 line-clamp-3">
                    {{ $idea->description }}
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                        <div class="hidden md:block font-bold text-gray-900">{{ $idea->user->name }}</div>
                        <div class="hidden md:block">&bull;</div>
                        <div>{{ $idea->created_at->diffForHumans() }}</div>
                        <div>&bull;</div>
                        <div>{{ $idea->category->name }}</div>
                        <div>&bull;</div>
                        <div class="text-gray-900">{{ $idea->comments()->count()}} Comments</div>
                    </div>
                    <div
                        x-data="{ isOpen: false }"  
                        class="flex items-center space-x-2 mt-4 md:mt-0">
                        <div class="{{ $idea->status->classes }} text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">
                            {{ $idea->status->name }}
                        </div>
                        <div class="relative">
                            <button
                                @click="isOpen = !isOpen"  
                                class="bg-gray-100 relative hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in px-3">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                </svg>
                            </button>
                            
                            <ul 
                                x-cloak
                                x-show.transition.origin.top.left="isOpen"
                                @click.away="isOpen = false"
                                @keydown.escape.window="isOpen = false"
                                class="absolute w-44 text-left font-semibold bg-white shadow-dialog rounded-xl py-3 z-10 md:ml-8 top-8 md:top-6 right-0 md:left-0"
                            >
                                @can('update', $idea)
                                    <li>
                                        <a 
                                            href="#" 
                                            @click="
                                                isOpen = false 
                                                $dispatch('custom-show-edit-modal')
                                            "
                                            class="hover:bg-gray-100 block px-5 py-3">Edit Idea</a>
                                    </li> 
                                @endcan
                                @can('update', $idea)
                                    <li>
                                        <a 
                                            href="#" 
                                            @click="
                                                isOpen = false 
                                                $dispatch('custom-show-delete-modal')
                                            "
                                            class="hover:bg-gray-100 block px-5 py-3">Delete Post</a>
                                    </li>
                                @endcan
                                <!-- <li><a href="#" class="hover:bg-gray-100 block px-5 py-3">Mark as Spam</a></li> -->
                            </ul>
                            
                        </div>
                        
                    </div>
                    <div class="flex items-center md:hidden mt-4 md:mt-0">
                        <div class="bg-gray-100 text-center rounded-xl h-10 px-4 py-2 pr-8">
                            <div class="text-sm font-bold leading-none @if($hasVoted) text-blue @endif">{{ $voteCount }}</div>
                            <div class="text-xxs font-semibold leading-none text-gray-400">Votes</div>
                        </div>
                        @if($hasVoted)
                            <button class="w-20 bg-blue text-white border border-gray-200 hover:bg-blue-hover font-bold text-xs uppercase rounded-xl transition duration-150 ease-in px-4 py-3 -mx-5">voted</button>
                        @else
                            <button class="w-20 bg-gray-200 border border-gray-200 hover:border-gray-400 font-bold text-xs uppercase rounded-xl transition duration-150 ease-in px-4 py-3 -mx-5">vote</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Ideas-container -->

    <div class="button-container flex items-center justify-between mt-6">
        <div class="flex flex-col md:flex-row items-center space-x-4 md:ml-6">
            <livewire:add-comment :idea="$idea" />
            @auth
                @if(auth()->user()->isAdmin())
                    <livewire:set-status :idea="$idea" />
                @endif
            @endauth
            
        </div>
        <div class="hidden md:flex items-center space-x-3">
            <div class="bg-white font-semibold text-center rounded-xl px-3 py-2">
                <div class="text-xl leading-snug @if($hasVoted) text-blue @endif">{{ $voteCount }}</div>
                <div class="text-gray-400 text-xs leading-none">Votes</div>
            </div>
            @if($hasVoted)
                <button 
                    wire:click.prevent="vote" 
                    type="button" 
                    class="w-32 h-11 text-xs bg-blue font-semibold text-white uppercase rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                    <span>Voted</span>
                </button>
            @else
                <button
                    wire:click.prevent="vote"  
                    type="button" 
                    class="w-32 h-11 text-xs bg-gray-200 font-semibold uppercase rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3">
                    <span>Vote</span>
                </button>
            @endif
        </div>
    </div><!-- End Button-container -->
</div>
