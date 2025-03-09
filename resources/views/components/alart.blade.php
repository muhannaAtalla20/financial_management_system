@if (session()->has($type))
    <div class="col-12 mb-4">
        <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
            @if(is_array(session($type)))
            <ul class="list-group" style="    height: 60px; overflow: hidden;">
                @foreach(session($type) as $error)
                    <li class="list-group-item">{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#logModal">
                <span aria-hidden="true">عرض الكل</span>
            </button>
            @elseif(is_string(session($type)))
                {{ session($type) }}
            @endif
            <button type="button"
                class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div> <!-- /. col -->
@endif
