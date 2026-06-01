<!-- Comments Section -->
<div class="comments-section mt-5">
    <h3>Comments ({{ $post->allComments()->count() }})</h3>
    
    @forelse($post->allComments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">
                    {{ $comment->author_name }} - 
                    @if($comment->created_at)
                        {{ $comment->created_at instanceof \Carbon\Carbon ? $comment->created_at->diffForHumans() : 'recently' }}
                    @else
                        recently
                    @endif
                </h6>
                <p class="card-text">{{ $comment->content }}</p>
                @if(!isset($comment->is_approved) || !$comment->is_approved)
                    <small class="text-muted">Pending approval</small>
                @endif
            </div>
        </div>
    @empty
        <p>No comments yet. Be the first to comment!</p>
    @endforelse
    
    <!-- Comment Form -->
    <div class="card mt-4">
        <div class="card-header">Leave a Comment</div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <form action="{{ route('comment.store', $post->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Name *</label>
                    <input type="text" name="author_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email *</label>
                    <input type="email" name="author_email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Comment *</label>
                    <textarea name="content" rows="4" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>
    </div>
</div>