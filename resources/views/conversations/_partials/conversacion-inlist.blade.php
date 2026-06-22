<li>
	<a href="{{ route('conversations.show', $conversation->id) }}"
		class="flex gap-4 p-4 rounded-lg border border-gray-200 border-l-4 border-l-gray-300 bg-gray-50 hover:bg-gray-100 hover:border-gray-300 dark:border-gray-700 dark:border-l-gray-500 dark:bg-gray-900/40 dark:hover:bg-gray-700/60 transition">

		<img src="{{ Storage::url($conversation->other->imagen ?? 'default-pp.png') }}" alt="{{ $conversation->other->name }}"
			class="h-14 w-14 shrink-0 rounded-full object-cover ring-2 ring-white dark:ring-gray-800">

		<div class="min-w-0 flex-1">
			<div class="font-semibold text-gray-900 dark:text-gray-100 truncate">
				{{ $conversation->other->name }}
			</div>

			@if($conversation->lastMessage)
				<p class="text-sm text-gray-600 dark:text-gray-300 truncate">
					{{ $conversation->lastMessage->sender->name }}:
					{{ $conversation->lastMessage->body }}
				</p>

				<p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
					{{ $conversation->updated_at }}
				</p>
			@endif
		</div>
	</a>
</li>
