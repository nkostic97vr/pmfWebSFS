@extends('layouts.website')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="show-profile bgc-main p-main">
                <h2 class="username">{{ $user->username }}</h2>
                <section>
                    <div class="avatar">
                        @avatar(big)
                    </div>
                    {{-- <p>
                        <a href="">Sve poruke korisnika {{ $user->username }}</a><br>
                        <a href="">Sve teme koje je započeo korisnik {{ $user->username }}</a><br>
                        <a href="">Sve teme u kojima je učestvovao korisnik {{ $user->username }}</a>
                    </p> --}}
                    <dl>
                        <dt>Pridružio</dt>
                        <dd>{{ extract_date($user->registered_at) }}</dd>
                        <dt>Ukupno poruka</b><dt>
                        <dd>{{ $user->posts()->get()->count() }}</dd>
                        <dt>Pol</dt>
                        <dd><?php
                            switch ($user->sex) {
                                case 'm': echo 'Muški'; break;
                                case 'f': echo 'Ženski'; break;
                                case 'o': echo 'Drugo'; break;
                                default: echo '-'; break;
                            }
                        ?></dd>
                    </dl>
                    <dl>
                        <dt>Datum rođenja</dt>
                        <dd>{{ $user->birthday_on ?: '-' }}</dd>
                        <dt>Mesto rođenja</dt>
                        <dd>{{ $user->birthplace ?: '-' }}</dd>
                        <dt>Prebivalište</dt>
                        <dd>{{ $user->residence ?: '-' }}</dd>
                        <dt>Zanimanje</dt>
                        <dd>{{ $user->job ?: '-' }}</dd>
                    </dl>
                    <dl>
                        <dt>O meni</dt>
                        <dd>{{ $user->about ?: '-' }}</dd>
                        <dt>Potpis</dt>
                        <dd>{{ $user->signature ?: '-' }}</dd>
                    </dl>
                </section>
                @if ($is_admin || $user->id == Auth::id())
                    <a class="btn btn-success" href="{{ route('users.edit', [$user->username]) }}">Izmeni profil</a>
                @endif
            </div>
        </div>
    </div>
@stop
