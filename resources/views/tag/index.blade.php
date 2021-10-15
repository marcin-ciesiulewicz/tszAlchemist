<a href="#" class="add-tag" title="Add Tag" style="color:#888;"
   data-campaign-id="{{ $campaign->id }}"><i class="fas fa-tag"></i></a>
<div class="tags-hide tags-container-{{ $campaign->id }} d-none"
     style="position: absolute;top: 20px;">
    <select class="form-control select2 select-tag select-tag-{{ $campaign->id }}"
            name="select-tag" id="select-tag">
        <option>Add Tag</option>
        @foreach($tags as $tag)
            @if(!$campaign->tags->contains('id', $tag->id))
                <option value="{{ $tag->id }}"
                        data-campaign-id="{{ $campaign->id }}">{{ $tag->name }}</option>
            @endif
        @endforeach
    </select>
</div>
<div class="selected-tags-{{$campaign->id}}">
    @foreach($campaign->tags as $id => $tag)
        <span class="tag d-inline-block" style="background-color: {{ $tag->color }};">
            <span class="tag-name">{{ $tag->name }}</span>
            <a href="#" class="remove-tag" data-campaign-id="{{ $campaign->id }}"
               data-tag-id="{{ $tag->id }}" data-tag-name="{{ $tag->name }}"><i
                    class="far fa-times-circle"></i></a>
        </span>
    @endforeach
</div>
