@extends('user.layouts.master')
@section('content')
    <div class="container">
        <div class="my-4">
            <div class="m-3">
                <form action="{{ route('contact#store') }}" class="fs-form" target="_top" method="POST">
                    @csrf
                    <div class="fs-field">
                        <label class="fs-label" for="name">Your Name</label>
                        <h2 class="h3 text-muted">{{ Auth::user()->name }}</h2>
                        <input type="hidden" class="fs-input" id="name" value="{{ Auth::user()->name }}"
                            name="name" required />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="email">Email</label>
                        <input class="fs-input" id="email" name="email"
                            value="{{ Auth::user()->email, old('email') }}" placeholder="{{ Auth::user()->email }}"
                            required />
                        <p class="fs-description">
                            This will help me respond to your query via an email.
                        </p>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="title">Title</label>
                        <input class="fs-input" id="title" name="title" required />
                        <p class="fs-description">What title would you like to use?</p>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="message">Message</label>
                        <textarea class="fs-textarea" id="message" name="message" required>{{ old('message') }}</textarea>
                        <p class="fs-description">What would you like to text us?</p>
                    </div>
                    <div class="fs-button-group">
                        <button class="fs-button" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
