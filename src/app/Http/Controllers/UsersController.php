<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Factory as ValidationFactory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{
    private function renderUserPage(array $arResult){
        return view('user', $arResult);
    }

    public function showNewUserPage(Request $request){
        if (($arOldUserData = $request->old('user')) == null)
            $objUser = new User();
        else
            $objUser = new User($arOldUserData);

        $arResult = [
            'objUser' => $objUser,
            'bNewUser' => false,
        ];

        return $this->renderUserPage($arResult);
    }

    public function showUserPage(int $id){
        try {
            $objUser = User::findOrFail($id);
        }
        catch (\Exception $e){
            throw new NotFoundHttpException('Пользователь не найден');
        }

        $arResult = [
            'objUser' => $objUser,
            'bNewUser' => true
        ];

        return $this->renderUserPage($arResult);
    }

    public function saveUser(Request $request, Redirector $redirector, HashManager $hashManager, ValidationFactory $validationFactory){
        if (!$request->has('user'))
            throw new NotFoundHttpException();

        $arUserData = $request->input('user');
        $objValidator = $this->getSaveFormValidator($arUserData, $validationFactory);

        if ($objValidator->fails()){
            return $redirector->back()->withErrors($objValidator)->withInput();
        }

        $objUser = new User($arUserData);
        $objUser->password = $hashManager->make($arUserData['password']);
        $objUser->save();

        return $redirector->route('show-user', ['id' => $objUser->id]);
    }

    private function getSaveFormValidator(array $arUserData, ValidationFactory $validationFactory): Validator
    {
        return $validationFactory->make(
            $arUserData,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255|unique:users',
                'password' => 'required|string|confirmed',
            ],
            [
                'name.required' => 'Необходимо ввести имя',
                'name.max' => 'Слишком длинное имя',
                'email.required' => 'Необходимо ввести адрес электронной почты',
                'email.unique' => 'Пользователь с таким адресом электронной почты уже существует',
                'password.required' => 'Необходимо ввести пароль',
                'password.confirmed' => 'Пароль не совпал с введенным подтверждением',
            ]
        );
    }
}
