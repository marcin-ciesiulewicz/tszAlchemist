<h1>{{ $type }} Notification</h1>

@if(isset($data['msg']) && is_array($data['msg']))
    @foreach($data['msg'] as $msg)
        <hr>
        <p>{!! $msg !!}</p>
    @endforeach

@elseif(isset($data['msg']) && !is_array($data['msg']))
    <hr>
    <p>{!! $data['msg'] !!}</p>

@elseif(isset($data['username']) && isset($data['domain']))
    <h2>{!! $data['username'] !!}</h2>
    <p>You have been assigned as a new <strong>{{ $type }}</strong> for campaign: {{ $data['domain'] }}</p>

@else

@endif
<br>
Thanks,<br>
{{ config('app.name') }}


