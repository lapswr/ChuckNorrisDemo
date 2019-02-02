@extends('layouts.base')

@section('title', 'Provide Emails')

@section('content')
    <div class="m-b-md">
        Emails List :
        <ul class="list-group" style="list-style-type:none;">
            @foreach( $emailsCollection as $email)
                <li class="list-group-item">{{$email['email']}} <button class="btn btn-default send-joke float-right" data-email="{{$email['email']}}" >Send Joke</button></li>
            @endforeach
        </ul>
        <button class="btn btn-default send-jokes" data-emails="{{$emailsCollection->implode('email', ',')}}" >Send Joke to All Emails</button> or
        <a class="btn btn-default" href="{{url('/')}}" >Go Back</a>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $( ".send-joke" ).click(function() {
                var button = $( this );
                var email = button.data('email');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{url('/send/email')}}",
                    method: "POST",
                    data: { _token: CSRF_TOKEN, email : email },
                }).done(function() {
                    button.addClass( "btn-success" );
                    button.removeClass( "btn-default" );
                    button.attr( "disabled", "disabled" );
                    alert( "Joke Send Successfully!");
                }).fail(function( jqXHR, textStatus ) {
                    button.addClass( "btn-danger" );
                    button.removeClass( "btn-default" );
                    button.attr( "disabled", "disabled" );
                    alert( "Failed to send joke");
                });
            });
            $( ".send-jokes" ).click(function() {
                var button = $( this );
                var emails = button.data('emails');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{url('/send/email')}}",
                    method: "POST",
                    data: { _token: CSRF_TOKEN, emails : emails },
                }).done(function() {
                    button.addClass( "btn-success" );
                    button.removeClass( "btn-default" );
                    button.attr( "disabled", "disabled" );
                    alert( "Joke Send Successfully!");
                }).fail(function( jqXHR, textStatus ) {
                    button.addClass( "btn-danger" );
                    button.removeClass( "btn-default" );
                    button.attr( "disabled", "disabled" );
                    alert( "Failed to send joke");
                });
            });
        });
    </script>
@endsection