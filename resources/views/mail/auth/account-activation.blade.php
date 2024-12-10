@extends('mail.templates.auth')
@section('title', 'Account Activation')

@section('content')

    <h1 class="text-center">Hello, {{$data['user']['full_name']}}</h1>

    <p class="text-center">You are receiving this email because an account was created for you in our platform.</p>

    @if(isset($data) && $data['url'])
        <table align="center" role="presentation" style="width: 100%; border: none; margin-bottom:10px;">
            <tr>
                <td align="center">
                    <a class="button" href="{{$data['url']}}">Activate Account</a>
                </td>
            </tr>
        </table>

    @endif

    <p class="text-center">Regards, {{ env('APP_NAME') }}</p>
    <hr>
    <p class="text-center">If you're having trouble clicking the "Activate Account" button, copy and paste the URL below into your web browser:
        <a href="{{$data['url']}}">{{$data['url']}}</a></p>
@endsection
