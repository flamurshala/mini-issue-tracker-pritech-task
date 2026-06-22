@extends('layouts.app')

@section('title', 'Tags')

@section('content')
    <h1>Tags</h1>

    <section style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; margin-bottom: 24px; padding: 20px;">
        <h2 style="margin-top: 0;">Create Tag</h2>

        <form action="{{ route('tags.store') }}" method="POST" style="display: grid; gap: 16px; max-width: 600px;">
            @csrf

            <div>
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
            </div>

            <div>
                <label for="color">Color</label>
                <input id="color" type="text" name="color" value="{{ old('color') }}" placeholder="Example: #2563eb or Blue" style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
            </div>

            <div>
                <button type="submit" style="background: #2563eb; border: 0; border-radius: 6px; color: #ffffff; cursor: pointer; padding: 10px 14px;">Create Tag</button>
            </div>
        </form>
    </section>

    <section>
        <h2>Existing Tags</h2>

        @if ($tags->isEmpty())
            <p>No tags found.</p>
        @else
            <table style="width: 100%; border-collapse: collapse; background: #ffffff;">
                <thead>
                    <tr>
                        <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Name</th>
                        <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Color</th>
                        <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $tag->name }}</td>
                            <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">
                                @if ($tag->color)
                                    <span style="align-items: center; display: inline-flex; gap: 8px;">
                                        <span style="background: {{ $tag->color }}; border: 1px solid #d1d5db; border-radius: 999px; display: inline-block; height: 16px; width: 16px;"></span>
                                        {{ $tag->color }}
                                    </span>
                                @else
                                    No color
                                @endif
                            </td>
                            <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $tag->created_at?->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection
