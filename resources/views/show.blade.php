<x-app-layout>
	<div>
		<a href="/" class="flex items-center font-semibold hover:underline">
			<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
			  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
			</svg>
			<span class="ml-2">All ideas</span>
		</a>
	</div>
	<div class="ideas-container bg-white rounded-xl flex mt-4">
        <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
            <div class="flex-none mx-2 md:mx-0">
                <a href="#" >
                <img src="https://source.unsplash.com/200x200/?face&crop=face&v=1" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
            </div>
            <div class="w-full mx-2 md:mx-4">
                <h4 class="text-xl font-semibold">
                    <a href="#" class="hover:underline">A random title can go here</a>
                </h4>
                <div class="text-gray-600 mt-3 line-clamp-3">
                    Lorem ipsum dolor, sit amet, consectetur adipisicing elit. 
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                    	<div class="hidden md:block font-bold text-gray-900">John Doe</div>
                        <div class="hidden md:block">&bull;</div>
                        <div>10 hours ago</div>
                        <div>&bull;</div>
                        <div>Category</div>
                        <div>&bull;</div>
                        <div class="text-gray-900">3 Comments</div>
                    </div>
                    <div
                    	x-data="{ isOpen: false }"  
                    	class="flex items-center space-x-2 mt-4 md:mt-0">
                        <div class="bg-gray-200 text-xs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">
                            Open
                        </div>
                        <button
                        	@click="isOpen = !isOpen"  
                        	class="bg-gray-100 relative hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in px-3">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                            <ul 
                            	x-cloak
                                x-show.transition.origin.top.left="isOpen"
                                @click.away="isOpen = false"
                                @keydown.escape.window="isOpen = false"
                            	class="absolute w-44 text-left font-semibold bg-white shadow-dialog rounded-xl py-3 z-10 md:ml-8 top-8 md:top-6 right-0 md:left-0">
                                <li><a href="#" class="hover:bg-gray-100 block px-5 py-3">Mark as Spam</a></li>
                                <li><a href="#" class="hover:bg-gray-100 block px-5 py-3">Delete Post</a></li>
                            </ul>
                        </button>
                    </div>
                    <div class="flex items-center md:hidden mt-4 md:mt-0">
                        <div class="bg-gray-100 text-center rounded-xl h-10 px-4 py-2 pr-8">
                            <div class="text-sm font-bold leading-none">12</div>
                            <div class="text-xxs font-semibold leading-none text-gray-400">Votes</div>
                        </div>
                        <button class="w-20 bg-gray-200 border border-gray-200 hover:border-gray-400 font-bold text-xs uppercase rounded-xl transition duration-150 ease-in px-4 py-3 -mx-5">vote</button>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Ideas-container -->

    <div class="button-container flex items-center justify-between mt-6">
    	<div class="flex flex-col md:flex-row items-center space-x-4 md:ml-6">
    		<div class="relative" x-data="{ isReply: false }">
    			<button 
    				@click="isReply = !isReply" 
		            type="button" 
		            class="flex items-center justify-center w-32 h-11 text-sm text-white bg-blue font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
		             <span class="ml-1">Reply</span>
		        </button>
		        <div
		            x-cloak
                    x-show.transition.origin.top.left="isReply"
                    @click.away="isReply = false"
                    @keydown.escape.window="isReply = false"  
		        	class="absolute z-10 w-64 md:w-104 text-left font-semibold text-sm bg-white shadow-dialog rounded-xl mt-2">
		        	<form action="#" class="space-y-4 px-4 py-6">
		        		<div>
		        			<textarea name="post_comment" id="post_comment" cols="30" rows="4" class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 border-none px-4 py-2" placeholder="Go ahead, don't be shy. Share your thoughs..."></textarea>
		        		</div>
		        		<div class="flex flex-col md:flex-row items-center md:space-x-3">
		        			<button 
					            type="button" 
					            class="flex items-center justify-center w-full md:w-36 h-9 text-xs text-white bg-blue font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in">
					             Post Comment
					        </button>

					        <button 
				                type="button" 
				                class="flex items-center justify-center w-full md:w-36 h-9 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-2 md:mt-0">
				                <svg class="text-gray-600 w-4 transform -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
				                <span>Attach</span>
				             </button>
		        		</div>
		        	</form>
		        </div>
    		</div>
	        <div class="relative" x-data="{ isStatus: false }" >
	        	<button 
	        		@click="isStatus = !isStatus" 
	                type="button" 
	                class="flex items-center justify-center w-36 h-11 text-sm bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-2 md:mt-0">
	                <span>Set status</span>
	                <svg class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
					</svg>
	            </button>
	            <div
	             	x-cloak
                    x-show.transition.origin.top.left="isStatus"
                    @click.away="isStatus = false"
                    @keydown.escape.window="isStatus = false" 
	             	class="absolute z-20 w-64 md:w-76 text-left font-semibold text-sm bg-white shadow-dialog rounded-xl mt-2">
		        	<form action="#" class="space-y-4 px-4 py-6">
		        		<div class="space-y-2">
		        			<div>
		        				<label class="inline-flex items-center">
		        					<input type="radio" class="bg-gray-200 text-purple border-none" name="open" id="open" value="1">
		        					<span class="ml-2">Open</span>
		        				</label>
		        			</div>
		        			<div>
		        				<label class="inline-flex items-center">
		        					<input type="radio" checked="" class="bg-gray-200 text-blue border-none" name="open" value="">
		        					<span class="ml-2">Considering</span>
		        				</label>
		        			</div>
		        			<div>
		        				<label class="inline-flex items-center">
		        					<input type="radio" class="bg-gray-200 text-yellow border-none" name="open"  value="">
		        					<span class="ml-2">In Progress</span>
		        				</label>
		        			</div>
		        			<div>
		        				<label class="inline-flex items-center">
		        					<input type="radio" class="bg-gray-200 text-green border-none" name="open"  value="">
		        					<span class="ml-2">Implemented</span>
		        				</label>
		        			</div>
		        			<div>
		        				<label class="inline-flex items-center">
		        					<input type="radio" class="bg-gray-200 text-red border-none" name="open" value="">
		        					<span class="ml-2">Closed</span>
		        				</label>
		        			</div>
		        		</div>
		        		<div>
		        			<textarea name="post_comment" id="post_comment" cols="30" rows="3" class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 border-none px-4 py-2" placeholder="Add an update comment (optional)"></textarea>
		        		</div>
		        		<div class="flex items-center space-x-3">
					        <button 
				                type="button" 
				                class="flex items-center justify-center w-36 h-9 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3">
				                <svg class="text-gray-600 w-4 transform -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor">
	                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
	                            </svg>
				                <span>Attach</span>
				             </button>

				             <button 
					            type="button" 
					            class="flex items-center justify-center w-36 h-9 text-xs text-white bg-blue font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in">
					             Update
					        </button>
		        		</div>
		        		<div>
		        			<label class="font-normal inline-flex items-center">
		        				<input type="checkbox" name="notify_voters" class="rounded bg-gray-200" checked="">
		        				<span class="ml-2">Notify all voters</span>
		        			</label>
		        		</div>
		        	</form>
		        </div>
	        </div>
            
    	</div>
    	<div class="hidden md:flex items-center space-x-3">
    		<div class="bg-white font-semibold text-center rounded-xl px-3 py-2">
    			<div class="text-xl leading-snug">12</div>
    			<div class="text-gray-400 text-xs leading-none">Votes</div>
    		</div>
    		<button 
                type="button" 
                class="w-32 h-11 text-xs bg-gray-200 font-semibold uppercase rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3">
                <span>Vote</span>
             </button>
    	</div>
    </div><!-- End Button-container -->

    <div class="comments-container relative space-y-6 md:ml-22 pt-4 my-8 mt-1">
    	<div class="comment-container relative bg-white rounded-xl flex mt-4">
	        <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
	            <div class="flex-none">
	                <a href="#" >
		                <img src="https://source.unsplash.com/200x200/?face" alt="avatar" class="w-14 h-14 rounded-xl">
		            </a>
	            </div>
	            <div class="w-full md:mx-4">
	                <div class="text-gray-600 mt-3 line-clamp-3">
	                    Atque ad cumque quisquam alias, mollitia maiores in, tempore quaerat quidem quae ducimus excepturi?
	                </div>

	                <div class="flex items-center justify-between mt-6">
	                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
	                    	<div class="font-bold text-gray-900">Mary Doe</div>
	                        <div>10 hours ago</div>
	                    </div>
	                    <div 
	                    	x-data="{ isOpen: false }" 
	                    	class="flex items-center space-x-2"> 
	                        <button
	                        	@click="isOpen = !isOpen"  
	                        	class="bg-gray-100 relative hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in px-3">
	                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
	                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
	                            </svg>
	                            <ul 
	                            	x-cloak
                                    x-show.transition.origin.top.left="isOpen"
                                    @click.away="isOpen = false"
                                    @keydown.escape.window="isOpen = false"
	                            	class="absolute z-10 w-44 text-left font-semibold bg-white shadow-dialog rounded-xl py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0">
	                                <li><a href="#" class="hover:bg-gray-100 block px-5 py-3">Mark as Spam</a></li>
	                                <li><a href="#" class="hover:bg-gray-100 block px-5 py-3">Delete Post</a></li>
	                            </ul>
	                        </button>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div><!-- End Comment-container -->
	    <div class="is-admin comment-container relative bg-white rounded-xl flex mt-4">
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
	    </div><!-- End Comment-container -->
	    <div class="comment-container relative bg-white rounded-xl flex mt-4">
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
	    </div><!-- End Comment-container -->
    </div><!-- End Comments-container -->
    
</x-app-layout>