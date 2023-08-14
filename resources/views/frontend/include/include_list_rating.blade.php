@foreach ($ratings as $rating)
    <div class="comment-box d-flex mb-3">
        <div class="comment-avatar">
            {{ getStringFirst($rating->customer->name) }}
        </div>
        <div class="comment-content">
            <div class="comment-name">{{ $rating->customer->name }}</div>
            <div class="list-star">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= $rating->num_star ? 'active' : '' }}"></i>
                @endfor
            </div>
            <div class="comment-description">{{ $rating->content }}</div>
        </div>

    </div>
@endforeach

{{ $ratings->withQueryString()->links() }}

