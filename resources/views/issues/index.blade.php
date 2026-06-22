@extends('layouts.app')

@section('title', 'Issues')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px;">
        <h1 style="margin: 0;">Issues</h1>
        <a href="{{ route('issues.create') }}" style="background: #2563eb; border-radius: 6px; color: #ffffff; padding: 10px 14px;">Create Issue</a>
    </div>

    <form action="{{ route('issues.index') }}" method="GET" style="align-items: end; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; display: grid; gap: 16px; grid-template-columns: repeat(4, minmax(0, 1fr)); margin-bottom: 20px; padding: 16px;">
        <div>
            <label for="status">Status</label>
            <select id="status" name="status" style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
                <option value="">All statuses</option>
                <option value="open" @selected(request('status') === 'open')>Open</option>
                <option value="in_progress" @selected(request('status') === 'in_progress')>In Progress</option>
                <option value="closed" @selected(request('status') === 'closed')>Closed</option>
            </select>
        </div>

        <div>
            <label for="priority">Priority</label>
            <select id="priority" name="priority" style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
                <option value="">All priorities</option>
                <option value="low" @selected(request('priority') === 'low')>Low</option>
                <option value="medium" @selected(request('priority') === 'medium')>Medium</option>
                <option value="high" @selected(request('priority') === 'high')>High</option>
            </select>
        </div>

        <div>
            <label for="tag">Tag</label>
            <select id="tag" name="tag" style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
                <option value="">All tags</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @selected((string) request('tag') === (string) $tag->id)>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #2563eb; border: 0; border-radius: 6px; color: #ffffff; cursor: pointer; padding: 10px 14px;">Filter</button>
            <a href="{{ route('issues.index') }}" style="align-self: center;">Clear</a>
        </div>
    </form>

    @if ($issues->isEmpty())
        <p>No issues found.</p>
    @else
        <table style="width: 100%; border-collapse: collapse; background: #ffffff;">
            <thead>
                <tr>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Title</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Project</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Status</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Priority</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Due Date</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($issues as $issue)
                    <tr>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $issue->title }}</td>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $issue->project->name }}</td>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ str_replace('_', ' ', $issue->status) }}</td>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $issue->priority }}</td>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $issue->due_date ?? 'No due date' }}</td>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <a href="{{ route('issues.show', $issue) }}">View</a>
                                <a href="{{ route('issues.edit', $issue) }}">Edit</a>
                                <form action="{{ route('issues.destroy', $issue) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: 0; color: #dc2626; cursor: pointer; padding: 0;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $issues->links() }}
        </div>
    @endif
@endsection
