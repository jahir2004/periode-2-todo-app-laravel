@extends('layouts.app')

@section('content')
    <h1>API Tasks</h1>
    <pre>
        {{ json_encode($tasks, JSON_PRETTY_PRINT) }}
    </pre>
@endsection