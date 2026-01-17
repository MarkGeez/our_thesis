@foreach ($officials as $official)
            image: <img src="{{ asset('storage/' . $official->resident->image_path) }}" alt="profile picture"> 
            Hon: {{ $official->resident->firstName}} <b>{{$official->resident->lastName}}</b>
            position: {{ $official->position }}
            inaguration {{ date('F d, Y', strToTime($official->start))}}
            end: {{ date('F d, Y', strToTime($official->end))}}

        @endforeach