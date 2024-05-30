<div class="modal fade" id="like-user-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header border-success">
                <div class="h5 modal-title mx-auto my-2">
                    <i class="fa-solid fa-heart text-danger"></i> Likes
                </div>
            </div>
            <div class="modal-body mx-auto">
                
                    @foreach ($post->likes as $like)
                    <div class="row py-2">
                        <div class="col-auto">
                            @if ($like->user->avatar)
                                <a href="{{ route('profile.show', $like->user->id) }}">
                                    <img src="{{ $like->user->avatar }}" alt="{{$like->user->name  }}" class="rounded-circle d-block avatar-sm">
                                </a>
                            @else
                                <a href="{{ route('profile.show', $like->user->id) }}">
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                </a>
                            @endif
                        </div>
                        <div class="col mt-2">
                            <a href="{{ route('profile.show', $like->user->id) }}" class="text-decoration-none text-dark text-center">
                                <p>{{ $like->user->name }}</p>
                            </a>
                        </div>
                    </div>
                    @endforeach
                
            </div>
        </div>
    </div>
</div>











