<div class="comment-container relative bg-white rounded-xl flex transition duration-500 ease-in mt-4">
    <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
        <div class="flex-none">
            <a href="#" >
                <img src="{{ $comment->user->getAvatar()}}" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
        </div>
        <div class="w-full md:mx-4">
            <div class="text-gray-600 line-clamp-3">
                {{ $comment->body }}
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                    <div class="font-bold text-gray-900">{{ $comment->user->name }}</div>
                    @if( $comment->user->id == $ideaUserId) 
                        <div>&bull;</div>
                        <div class="rounded-full border border-gray-100 px-3 py-1">OP</div>
                    @endif
                    <div>&bull;</div>
                    <div>{{ $comment->created_at->diffForHumans()}}</div>
                </div>
                @auth
                <div 
                    x-data="{ isOpen: false }" 
                    class="flex items-center space-x-2"> 
                    <div class="relative">
                        <button
                            @click="isOpen = !isOpen"  
                            class="bg-gray-100 relative hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in px-3">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </button>
                        @can('update', $comment)
                            <ul 
                                x-cloak
                                x-show.transition.origin.top.left="isOpen"
                                @click.away="isOpen = false"
                                @keydown.escape.window="isOpen = false"
                                class="absolute z-10 w-44 text-left font-semibold bg-white shadow-dialog rounded-xl py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0">
                                
                                <li>
                                    <a 
                                        href="#" 
                                        @click.prevent="
                                            isOpen = false 
                                            Livewire.emit('setEditComment', {{ $comment->id }})
                                        "
                                        class="hover:bg-gray-100 block px-5 py-3">Edit Comment</a>
                                </li> 

                                <li>
                                    <a 
                                        href="#" 
                                        @click.prevent="
                                            isOpen = false 
                                            Livewire.emit('setDeleteComment', {{ $comment->id }})
                                        "
                                        class="hover:bg-gray-100 block px-5 py-3">Delete Comment</a>
                                </li> 
                                
                                <!-- <li><a href="#" class="hover:bg-gray-100 block px-5 py-3">Mark as Spam</a></li> -->
                                <!-- <li><a href="#" class="hover:bg-gray-100 block px-5 py-3">Delete Comment</a></li> -->
                            </ul>
                        @endcan
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
</div><!-- End Comment-container -->







    <!-- <div class="is-admin comment-container relative bg-white rounded-xl flex mt-4">
        <div class="flex flex-1 px-4 py-6">
            <div class="flex-none">
                <a href="#" >
                <img src="https://source.unsplash.com/200x200/?face&crop=face&v=3" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
            <div class="text-blue font-bold text-center uppercase text-xxs mt-1">Admin</div>
            </div>
            <div class="w-full mx-4">
                <h4 class="text-xl font-semibold">
                    <a href="#" class="hover:underline">Status Changed to "Under Consideration"</a>
                </h4>
                <div class="text-gray-600 mt-3 line-clamp-3">
                    Veritatis at quam, ipsa assumenda! Dolore, ipsa, vero. Vero architecto similique labore hic repudiandae consequuntur veritatis dolore? Eius.
                </div>

                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                        <div class="font-bold text-blue">Andrea</div>
                        <div>10 hours ago</div>
                    </div>
                    <div class="flex items-center space-x-2"> 
                        <button class="bg-gray-100 relative hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in px-3">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                            <ul class="hidden absolute w-44 text-left font-semibold bg-white shadow-dialog rounded-xl py-3 ml-8">
                                <li><a href="#" class="hover:bg-gray-100 block px-5 py-3">Mark as Spam</a></li>
                                <li><a href="#" class="hover:bg-gray-100 block px-5 py-3">Delete Post</a></li>
                            </ul>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> --> <!-- End Comment-container -->
    <!-- <div class="comment-container relative bg-white rounded-xl flex mt-4">
        <div class="flex flex-1 px-4 py-6">
            <div class="flex-none">
                <a href="#" >
                <img src="https://source.unsplash.com/200x200/?face&crop=face&v=2" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
            </div>
            <div class="w-full mx-4">
                <div class="text-gray-600 line-clamp-3">
                    Atque ad cumque quisquam alias, mollitia maiores in, tempore quaerat quidem quae ducimus excepturi?
                </div>

                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                        <div class="font-bold text-gray-900">Mark Doe</div>
                        <div>10 hours ago</div>
                    </div>
                    <div class="flex items-center space-x-2"> 
                        <button class="bg-gray-100 relative hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in px-3">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                            <ul class="hidden absolute w-44 text-left font-semibold bg-white shadow-dialog rounded-xl py-3 ml-8">
                                <li><a href="#" class="hover:bg-gray-100 block px-5 py-3">Mark as Spam</a></li>
                                <li><a href="#" class="hover:bg-gray-100 block px-5 py-3">Delete Post</a></li>
                            </ul>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> --><!-- End Comment-container -->