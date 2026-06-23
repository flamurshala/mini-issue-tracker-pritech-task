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
        <div id="tag-message" style="margin-bottom: 16px;"></div>

        <ul id="attached-tags" style="display: grid; gap: 10px; list-style: none; margin: 0 0 18px; padding: 0;">
            @foreach ($issue->tags as $tag)
                <li data-tag-id="{{ $tag->id }}" style="align-items: center; border: 1px solid #e5e7eb; border-radius: 6px; display: flex; gap: 10px; justify-content: space-between; padding: 10px;">
                    <span>
                        @if ($tag->color)
                            <span style="background: {{ $tag->color }}; border: 1px solid #d1d5db; border-radius: 999px; display: inline-block; height: 14px; margin-right: 6px; vertical-align: middle; width: 14px;"></span>
                        @endif
                        <span>{{ $tag->name }}</span>
                    </span>
                    <button type="button" data-detach-url="{{ route('issues.tags.detach', [$issue, $tag]) }}" style="background: none; border: 0; color: #dc2626; cursor: pointer; padding: 0;">Remove</button>
                </li>
            @endforeach
        </ul>

        <p id="no-tags-message" @if ($issue->tags->isNotEmpty()) style="display: none;" @endif>No tags assigned.</p>

        <form id="attach-tag-form" action="{{ route('issues.tags.attach', $issue) }}" method="POST" style="display: flex; gap: 10px; max-width: 520px;">
            @csrf
            <select id="tag_id" name="tag_id" style="flex: 1; padding: 10px;" @disabled($availableTags->isEmpty())>
                <option value="">Select a tag</option>
                @foreach ($availableTags as $tag)
                    <option value="{{ $tag->id }}" data-color="{{ $tag->color }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            <button id="attach-tag-button" type="submit" style="background: #2563eb; border: 0; border-radius: 6px; color: #ffffff; cursor: pointer; padding: 10px 14px;" @disabled($availableTags->isEmpty())>Attach Tag</button>
        </form>
    </section>

    <section style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; padding: 20px;">
        <h2 style="margin-top: 0;">Comments</h2>
        <div id="comments-message" style="margin-bottom: 16px;"></div>
        <div id="comments-errors" style="margin-bottom: 16px;"></div>
        <div id="comments-list" style="display: grid; gap: 12px; margin-bottom: 16px;"></div>
        <div id="comments-pagination" style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px;"></div>

        <form id="comment-form" action="{{ route('issues.comments.store', $issue) }}" method="POST" style="display: grid; gap: 16px; max-width: 700px;">
            @csrf

            <div>
                <label for="author_name">Author Name</label>
                <input id="author_name" type="text" name="author_name" style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
            </div>

            <div>
                <label for="body">Comment</label>
                <textarea id="body" name="body" rows="4" style="display: block; margin-top: 6px; width: 100%; padding: 10px;"></textarea>
            </div>

            <div>
                <button type="submit" style="background: #2563eb; border: 0; border-radius: 6px; color: #ffffff; cursor: pointer; padding: 10px 14px;">Add Comment</button>
            </div>
        </form>
    </section>

    <script>
        const attachTagForm = document.getElementById('attach-tag-form');
        const tagSelect = document.getElementById('tag_id');
        const attachTagButton = document.getElementById('attach-tag-button');
        const attachedTags = document.getElementById('attached-tags');
        const tagMessage = document.getElementById('tag-message');
        const noTagsMessage = document.getElementById('no-tags-message');
        const csrfToken = attachTagForm.querySelector('input[name="_token"]').value;
        const detachBaseUrl = @json(url('issues/' . $issue->id . '/tags'));
        const commentsIndexUrl = @json(route('issues.comments.index', $issue));
        const commentForm = document.getElementById('comment-form');
        const commentsMessage = document.getElementById('comments-message');
        const commentsErrors = document.getElementById('comments-errors');
        const commentsList = document.getElementById('comments-list');
        const commentsPagination = document.getElementById('comments-pagination');
        const authorNameInput = document.getElementById('author_name');
        const commentBodyInput = document.getElementById('body');

        function showTagMessage(message, type = 'success') {
            tagMessage.textContent = message;
            tagMessage.className = type === 'success' ? 'alert alert-success' : 'alert alert-error';
        }

        function clearTagMessage() {
            tagMessage.textContent = '';
            tagMessage.className = '';
        }

        function refreshEmptyStates() {
            const hasAttachedTags = attachedTags.querySelectorAll('li').length > 0;
            const hasAvailableTags = tagSelect.querySelectorAll('option[value]:not([value=""])').length > 0;

            noTagsMessage.style.display = hasAttachedTags ? 'none' : 'block';
            tagSelect.disabled = !hasAvailableTags;
            attachTagButton.disabled = !hasAvailableTags;
        }

        function addAttachedTag(tag) {
            const item = document.createElement('li');
            item.dataset.tagId = tag.id;
            item.style.cssText = 'align-items: center; border: 1px solid #e5e7eb; border-radius: 6px; display: flex; gap: 10px; justify-content: space-between; padding: 10px;';

            const label = document.createElement('span');

            if (tag.color) {
                const color = document.createElement('span');
                color.style.cssText = 'border: 1px solid #d1d5db; border-radius: 999px; display: inline-block; height: 14px; margin-right: 6px; vertical-align: middle; width: 14px;';
                color.style.background = tag.color;
                label.appendChild(color);
            }

            const name = document.createElement('span');
            name.textContent = tag.name;
            label.appendChild(name);

            const button = document.createElement('button');
            button.type = 'button';
            button.dataset.detachUrl = `${detachBaseUrl}/${tag.id}`;
            button.textContent = 'Remove';
            button.style.cssText = 'background: none; border: 0; color: #dc2626; cursor: pointer; padding: 0;';

            item.appendChild(label);
            item.appendChild(button);
            attachedTags.appendChild(item);
        }

        function addAvailableTagOption(tag) {
            const option = document.createElement('option');
            option.value = tag.id;
            option.textContent = tag.name;

            if (tag.color) {
                option.dataset.color = tag.color;
            }

            tagSelect.appendChild(option);
        }

        function showCommentsMessage(message, type = 'success') {
            commentsMessage.textContent = message;
            commentsMessage.className = type === 'success' ? 'alert alert-success' : 'alert alert-error';
        }

        function clearCommentsMessages() {
            commentsMessage.textContent = '';
            commentsMessage.className = '';
            commentsErrors.textContent = '';
            commentsErrors.className = '';
        }

        function showCommentsErrors(errors) {
            commentsErrors.className = 'alert alert-error';

            const messages = errors ? Object.values(errors).flat() : ['Unable to save comment.'];
            const list = document.createElement('ul');

            messages.forEach((message) => {
                const item = document.createElement('li');
                item.textContent = message;
                list.appendChild(item);
            });

            commentsErrors.innerHTML = '';
            commentsErrors.appendChild(list);
        }

        function formatCommentDate(value) {
            if (!value) {
                return '';
            }

            return new Date(value).toLocaleString();
        }

        function buildCommentElement(comment) {
            const wrapper = document.createElement('article');
            wrapper.style.cssText = 'border: 1px solid #e5e7eb; border-radius: 6px; padding: 12px;';

            const header = document.createElement('div');
            header.style.cssText = 'display: flex; justify-content: space-between; gap: 12px; margin-bottom: 8px;';

            const author = document.createElement('strong');
            author.textContent = comment.author_name;

            const date = document.createElement('span');
            date.style.color = '#6b7280';
            date.textContent = formatCommentDate(comment.created_at);

            const body = document.createElement('p');
            body.style.margin = '0';
            body.textContent = comment.body;

            header.appendChild(author);
            header.appendChild(date);
            wrapper.appendChild(header);
            wrapper.appendChild(body);

            return wrapper;
        }

        function renderComments(comments) {
            commentsList.innerHTML = '';

            if (comments.length === 0) {
                const empty = document.createElement('p');
                empty.textContent = 'No comments yet.';
                commentsList.appendChild(empty);
                return;
            }

            comments.forEach((comment) => {
                commentsList.appendChild(buildCommentElement(comment));
            });
        }

        function renderCommentsPagination(links) {
            commentsPagination.innerHTML = '';

            links.forEach((link) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.innerHTML = link.label;
                button.disabled = !link.url || link.active;
                button.style.cssText = 'border: 1px solid #d1d5db; border-radius: 6px; cursor: pointer; padding: 8px 10px;';

                if (link.active) {
                    button.style.background = '#2563eb';
                    button.style.color = '#ffffff';
                }

                if (link.url) {
                    button.dataset.url = link.url;
                }

                commentsPagination.appendChild(button);
            });
        }

        async function loadComments(url = commentsIndexUrl) {
            clearCommentsMessages();

            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                showCommentsMessage('Unable to load comments.', 'error');
                return;
            }

            const data = await response.json();
            renderComments(data.data);
            renderCommentsPagination(data.links);
        }

        attachTagForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            clearTagMessage();

            const selectedOption = tagSelect.selectedOptions[0];

            if (!tagSelect.value) {
                showTagMessage('Please select a tag to attach.', 'error');
                return;
            }

            const response = await fetch(attachTagForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: new FormData(attachTagForm),
            });

            const data = await response.json();

            if (!response.ok) {
                const errors = data.errors ? Object.values(data.errors).flat().join(' ') : 'Unable to attach tag.';
                showTagMessage(errors, 'error');
                return;
            }

            addAttachedTag(data.tag);
            selectedOption.remove();
            tagSelect.value = '';
            refreshEmptyStates();
            showTagMessage(data.message);
        });

        attachedTags.addEventListener('click', async (event) => {
            const button = event.target.closest('button[data-detach-url]');

            if (!button) {
                return;
            }

            clearTagMessage();

            const item = button.closest('li');
            const tag = {
                id: item.dataset.tagId,
                name: item.querySelector('span span:last-child').textContent,
            };

            const colorIndicator = item.querySelector('span span:first-child');

            if (colorIndicator && colorIndicator !== item.querySelector('span span:last-child')) {
                tag.color = colorIndicator.style.background;
            }

            const response = await fetch(button.dataset.detachUrl, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
            });

            const data = await response.json();

            if (!response.ok) {
                showTagMessage(data.message || 'Unable to detach tag.', 'error');
                return;
            }

            item.remove();
            addAvailableTagOption(tag);
            refreshEmptyStates();
            showTagMessage(data.message);
        });

        refreshEmptyStates();
        loadComments();

        commentsPagination.addEventListener('click', (event) => {
            const button = event.target.closest('button[data-url]');

            if (!button) {
                return;
            }

            loadComments(button.dataset.url);
        });

        commentForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            clearCommentsMessages();

            const response = await fetch(commentForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: new FormData(commentForm),
            });

            const data = await response.json();

            if (!response.ok) {
                showCommentsErrors(data.errors);
                return;
            }

            const emptyMessage = commentsList.querySelector('p');

            if (emptyMessage && emptyMessage.textContent === 'No comments yet.') {
                emptyMessage.remove();
            }

            commentsList.prepend(buildCommentElement(data.comment));
            authorNameInput.value = '';
            commentBodyInput.value = '';
            showCommentsMessage(data.message);
        });
    </script>
@endsection
