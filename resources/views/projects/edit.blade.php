@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <h1>Edit Project</h1>

    <form action="{{ route('projects.update', $project) }}" method="POST" style="display: grid; gap: 16px; max-width: 700px;">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name', $project->name) }}" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" style="display: block; margin-top: 6px; width: 100%; padding: 10px;">{{ old('description', $project->description) }}</textarea>
        </div>

        <div>
            <label for="start_date">Start Date</label>
            <input id="start_date" type="date" name="start_date" value="{{ old('start_date', $project->start_date) }}" style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
        </div>

        <div>
            <label for="deadline">Deadline</label>
            <input id="deadline" type="date" name="deadline" value="{{ old('deadline', $project->deadline) }}" style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" style="background: #2563eb; border: 0; border-radius: 6px; color: #ffffff; cursor: pointer; padding: 10px 14px;">Update Project</button>
            <a href="{{ route('projects.show', $project) }}">Cancel</a>
        </div>
    </form>
@endsection
