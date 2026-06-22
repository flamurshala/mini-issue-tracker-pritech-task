@extends('layouts.app')

@section('title', $issue->title)

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px;">
        <h1 style="margin: 0;">{{ $issue->title }}</h1>
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('issues.index') }}">Back to Issues</a>
            <a href="{{ route('issues.edit', $issue) }}">Edit Issue</a>
            <form action="{{ route('issues.destroy', $issue) }}" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: none; border: 0; color: #dc2626; cursor: pointer; padding: 0;">Delete Issue</button>
            </form>
        </div>
    </div>

    <section style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; margin-bottom: 20px; padding: 20px;">
        <p><strong>Project:</strong> {{ $issue->project->name }}</p>
        <p><strong>Status:</strong> {{ str_replace('_', ' ', $issue->status) }}</p>
        <p><strong>Priority:</strong> {{ $issue->priority }}</p>
        <p><strong>Due Date:</strong> {{ $issue->due_date ?? 'No due date' }}</p>
        <p><strong>Description:</strong></p>
        <p>{{ $issue->description ?? 'No description provided.' }}</p>
    </section>

    <section style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; margin-bottom: 20px; padding: 20px;">
        <h2 style="margin-top: 0;">Tags</h2>
        @if ($issue->tags->isEmpty())
            <p>No tags assigned.</p>
        @else
            <ul>
                @foreach ($issue->tags as $tag)
                    <li>{{ $tag->name }}@if ($tag->color) ({{ $tag->color }}) @endif</li>
                @endforeach
            </ul>
        @endif
    </section>

    <section style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; padding: 20px;">
        <h2 style="margin-top: 0;">Comments</h2>
        @if ($issue->comments->isEmpty())
            <p>No comments yet.</p>
        @else
            <ul>
                @foreach ($issue->comments as $comment)
                    <li>
                        <strong>{{ $comment->author_name }}</strong>
                        <p>{{ $comment->body }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endsection
