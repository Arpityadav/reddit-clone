@extends('layouts.app')

@section('content')
    <form action="/threads" method="POST" class="lg:w-1/2 lg:mx-auto bg-white py-12 px-16 rounded shadow">

        @csrf

        <h1 class="text-2xl font-normal mb-10 text-center">Create a new thread</h1>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="title">Title</label>

            <div class="control">
                <input id="title"
                       type="text"
                       class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                       name="title"
                       required>
            </div>
        </div>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="description">Description</label>

            <div class="control">
                <textarea id="description"
                       class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                       name="description"
                       required>
                </textarea>
            </div>
        </div>

        <div class="field mb-6">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="button mr-2">
                    Publish
                </button>
            </div>
        </div>
    </form>
@endsection