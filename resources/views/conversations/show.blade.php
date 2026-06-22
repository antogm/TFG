@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen flex-col items-center py-10">
        <h2 class="text-xl font-bold mb-4 text-center text-white">
            {{ __('views.conversation_with', ['name' => $conversation->other->name]) }}
        </h2>

        <div class="flex flex-col w-1/2">

            {{-- MENSAJES --}}
            <div class="border rounded p-4 mb-4 h-80 overflow-y-auto bg-white dark:bg-gray-800 w-full">
                @forelse($conversation->messages as $message)
                    <div class="mb-2 w-full
                            {{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">

                        <div
                            class="inline-block px-3 py-2 rounded 
                                {{ $message->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-white' }}">

                            <p class="text-lg">{{ $message->sender->name }}</p>
                            <p class="text-sm">{{ $message->body }}</p>

                            <p class="text-xs">
                                {{ $message->created_at }}
                                
                                @if($message->sender_id === auth()->id() && $message->leido)
                                    | {{ __('views.message_read') }}
                                @endif
                        </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 dark:text-gray-400 py-10 w-full">
                        {{ __('views.no_messages') }}<br>
                        <span class="text-sm">{{ __('views.start_conversation_now') }}</span>
                    </div>
                @endforelse
            </div>

            {{-- FORMULARIO --}}
            <form method="POST" action="{{ route('messages.store', $conversation->id) }}" class="w-full">
                @csrf

                <textarea name="body" class="w-full border rounded p-2 mb-2 dark:bg-gray-800 dark:text-white"
                    required></textarea>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    {{ __('views.send') }}
                </button>
            </form>

        </div>
    </div>
@endsection
