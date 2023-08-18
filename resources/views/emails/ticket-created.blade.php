{{-- blade-formatter-disable --}}
<x-mail::message>
<h2>Ticket Title: {{ $ticket->title }}</h2>

A ticket has been created by {{ $ticket->user->name }}.<br>
Click the button to assign an agent.

<x-mail::button :url="$url">
Assign Agent
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
