@extends('mail.templates.auth')
@section('title', 'Reset Password')

@section('content')

    <h1 class="text-center">Hello!</h1>

    <p class="text-center">You are receiving this email because we received a password reset request for your account.</p>

    @if(isset($data) && $data['url'])
        <table align="center" role="presentation" style="width: 100%; border: none; margin-bottom:10px;">
            <tr>
                <td align="center">
                    <a class="button" href="{{$data['url']}}">Reset Password</a>
                </td>
            </tr>
        </table>

    @endif

    <p class="text-center">This password reset link will expire in 1 minutes.</p>

    <p class="text-center">If you did not request a password reset, no further action is required.</p>

    <p class="text-center">Regards, {{ env('APP_NAME') }}</p>

    <hr>

    <p class="text-center">If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
        <a href="{{$data['url']}}">{{$data['url']}}</a></p>
@endsection
