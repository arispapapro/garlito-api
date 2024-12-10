<?php

// Import Api Configuration
use App\Configuration\GarlitoApiConfiguration;

// Utilities
use Carbon\Carbon;

// Get Theme Primary Color
$primary_color = GarlitoApiConfiguration::GARLITO_THEME_PRIMARY_COLOR;


$lang = 'en';
$year = Carbon::now()->year;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        body,html{
            font-family: "Helvetica", serif;
        }
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }
            .header, .content, .footer {
                padding: 10px !important;
            }
        }
        .activate-account-btn{
            background: {{$primary_color}};
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            color: white;
        }

        .text-center{
            text-align: center;
        }
    </style>
</head>
<body style="margin: 0; padding: 20px; background:#d9d9d9;">




<table  width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" class="container" >
                <tr>
                    <td class="header" style="background-color: {{$primary_color}}; padding: 20px; text-align: center; color: #ffffff;">
                        <h1 style="margin: 0; font-size: 24px">
                            {{__('mail.user_registered.title' , [], $lang)}}
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td class="content" style="padding: 20px; background:white">
                        <header style="text-align: center; padding: 10px;">
                            <img width="150" height="50" src="{{url('images/branding/logo.png')}}" alt="Logo">
                        </header>
                        <p>{{__('mail.user_registered.hello_text' , [], $lang)}} <b>{{$first_name ?? ''}}</b></p>
                        <p class="text-center">
                            @if( isset($activate_account_url) )
                                <a class="activate-account-btn" href="{{$activate_account_url}}">Activate Account</a>
                            @endif
                        </p>
                        <p>{{__('mail.user_registered.content', [], $lang )}}</p>
                    </td>
                </tr>
                <tr>
                    <td class="footer" style="background-color: #f1f1f1; padding: 20px; text-align: center;">
                        <p style="margin: 0;">&copy; {{$year}} {{ env('APP_NAME', '') }}. All rights reserved.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
