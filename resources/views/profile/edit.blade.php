@extends('frontend.layouts.master')

@section('title', trans_lang('الملف الشخصي', 'My Profile'))

@section('content')

<div class="container py-5">
    <div class="row justify-content-center g-4">

        <div class="col-lg-8">

            {{-- Profile Info --}}
            @include('profile.partials.update-profile-information-form')

            <div style="margin-top:1.5rem">
                {{-- Password --}}
                @include('profile.partials.update-password-form')
            </div>

            <div style="margin-top:1.5rem">
                {{-- Delete Account --}}
                @include('profile.partials.delete-user-form')
            </div>

        </div>

    </div>
</div>

@endsection