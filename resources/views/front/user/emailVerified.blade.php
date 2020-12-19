@extends('front.layout')
@section('header')
    <link href="/front/frame/auth/loginRegister.css" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <div class="px-main-content-cover">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="px-auth-box-cover">
                    <div class="px-auth-box-head">
                        <div class="px-auth-box-head-title">Email Verified</div>
                    </div>
                    <div class="px-auth-box-body">
                        <div class="email-verify-body">
                            <h3>Congratulations!</h3>
                            <p>You have successfully signed up with <b><a href="/">Supreme Sifu</a></b>. <br>
                                You can either click <a href="/">Home Page</a> and go to Home Page of the  website or you can click this link to access your <a href="/user/dashboard">User Dashboard</a>.</p>
                            <p>Thank You.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection