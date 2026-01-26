@extends('layouts.sidebar')

@section('header', 'Mijn taken')

@section('content')
    <h1>Voltooide Taken</h1>
    <ul>
        @foreach ($tasks as $task)
            <li>{{ $task->title }} - {{ $task->description }}</li>
        @endforeach
    </ul>
@endsection