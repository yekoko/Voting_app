<x-app-layout>
	<div>
		<a href="{{ $back_url }}" class="flex items-center font-semibold hover:underline">
			<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
			  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
			</svg>
			<span class="ml-2">All ideas (or back to chosen category with filters)</span>
		</a>
	</div>
	

	<livewire:idea-show :idea="$idea" :voteCount="$voteCount"/>

	@can('update', $idea)
		<livewire:edit-idea :idea="$idea" />
	@endcan

	@can('delete', $idea)
		<livewire:delete-idea :idea="$idea" />
	@endcan
    

    <livewire:idea-comments :idea="$idea" />

    <livewire:edit-comment />
</x-app-layout>