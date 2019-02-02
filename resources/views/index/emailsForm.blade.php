@extends('layouts.base')

@section('title', 'Provide Emails')

@section('content')
    <div class="m-b-md">
        <form action="{{url('/emails/listing')}}"  method="post" >
            @csrf
            <div class="form-group {{($errors->any())?'has-error':''}}">
                <label for="emails">Please provide a comma separated list of emails :</label>
                <textarea name="emails" rows="5" cols="60" class="form-control" >{{ old('emails') }}</textarea>
                <br>
                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
@endsection