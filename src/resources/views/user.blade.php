<?php
/** @var \App\User $objUser */
/** @var bool $bNewUser */
/** @var \Illuminate\Support\ViewErrorBag $errors */
?>
@extends('base')

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/user.css') }}">
@endsection
@section('js')
    @parent
    <script src="{{ mix('assets/js/user.js') }}"></script>
@endsection

@section('body')
    <form method="POST" action="{{ route('save-user') }}">
        {{csrf_field()}}

        <div class="page-container">
            <div class="form-container">
                @if ($bNewUser)
                <div class="input-row-container">
                    <label for="id-input">ID</label>
                    <div class="input-container">
                        <input id="id-input"
                               type="text"
                               value="{{ $objUser->id }}"
                               disabled
                        >
                    </div>
                </div>
                @endif


                <div class="input-row-container">
                    <label for="name-input">Имя</label>
                    <div class="input-container">
                        <input id="name-input"
                               type="text"
                               value="{{ $objUser->name }}"
                               name="user[name]"
                               {{ $bNewUser?'disabled':'' }}
                        >
                        <div class="error-message">
                            @foreach ($errors->get('name') as $strMessage)
                                <div>{{ $strMessage }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="input-row-container">
                    <label for="email-input">Email</label>
                    <div class="input-container">
                        <input id="id-email"
                               type="text"
                               value="{{ $objUser->email }}"
                               name="user[email]"
                               {{ $bNewUser?'disabled':'' }}
                        >
                        <div class="error-message">
                            @foreach ($errors->get('email') as $strMessage)
                                <div>{{ $strMessage }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if (!$bNewUser)
                <div class="input-row-container">
                    <label for="password-input">Пароль</label>
                    <div class="input-container">
                        <input id="id-password"
                               type="password"
                               name="user[password]"
                        >
                        <div class="error-message">
                            @foreach ($errors->get('password') as $strMessage)
                                <div>{{ $strMessage }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="input-row-container">
                    <label for="password-confirmation-input">Подтверждение пароля</label>
                    <div class="input-container">
                        <input id="id-password-confirmation"
                               type="password"
                               name="user[password_confirmation]"
                        >
                    </div>
                </div>
                @endif

                @if (!$bNewUser)
                <div class="save-button-container">
                    <button class="save-button">
                        Сохранить
                    </button>
                </div>
                @endif
            </div>
        </div>
    </form>
@endsection