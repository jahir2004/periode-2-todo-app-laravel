@extends('layouts.sidebar')

@section('header', 'Notificaties Testen')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-blue-800 mb-4">🧪 Notificatiesysteem Testen</h2>
        <p class="text-blue-700 mb-4">
            Het notificatiesysteem is actief! Hier kun je testen of de email notificaties werken:
        </p>
        
        <div class="space-y-4">
            <div class="bg-white p-4 rounded border">
                <h3 class="font-semibold text-gray-800">✅ Wat werkt er:</h3>
                <ul class="list-disc list-inside text-gray-600 mt-2 space-y-1">
                    <li>Email notificatie bij het aanmaken van een nieuwe taak</li>
                    <li>Admin krijgt notificatie van alle nieuwe taken</li>
                    <li>Gebruiker krijgt bevestigingsmail</li>
                    <li>Mooie HTML email templates</li>
                </ul>
            </div>
            
            <div class="bg-yellow-50 p-4 rounded border border-yellow-200">
                <h3 class="font-semibold text-yellow-800">📧 Hoe testen:</h3>
                <ol class="list-decimal list-inside text-yellow-700 mt-2 space-y-1">
                    <li>Ga naar <a href="{{ route('tasks.create') }}" class="text-blue-600 underline">Nieuwe Taak</a></li>
                    <li>Maak een nieuwe taak aan</li>
                    <li>Check de Laravel logs in: <code class="bg-gray-100 px-1 rounded">storage/logs/laravel.log</code></li>
                    <li>Zoek naar de mail content in de logs</li>
                </ol>
            </div>
            
            <div class="bg-green-50 p-4 rounded border border-green-200">
                <h3 class="font-semibold text-green-800">🚀 Voor productie:</h3>
                <p class="text-green-700 mt-2">
                    Verander MAIL_MAILER in .env naar 'smtp' en configureer een echte mailservice 
                    zoals Mailtrap, SendGrid, of Gmail SMTP.
                </p>
            </div>
        </div>
        
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('tasks.create') }}" 
               class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                🎯 Nieuwe Taak Aanmaken
            </a>
            
            @if(app()->environment('local'))
            <a href="{{ route('test.notification') }}" 
               class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                🧪 Test Notificatie
            </a>
            @endif
        </div>
    </div>
    
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-800 mb-2">📋 Technische Details:</h3>
        <ul class="text-sm text-gray-600 space-y-1">
            <li><strong>Mail Driver:</strong> {{ config('mail.default') }}</li>
            <li><strong>From Address:</strong> {{ config('mail.from.address') }}</li>
            <li><strong>App Environment:</strong> {{ app()->environment() }}</li>
        </ul>
    </div>
</div>
@endsection