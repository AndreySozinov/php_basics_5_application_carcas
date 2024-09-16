<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Render;
use Geekbrains\Application1\Models\User;

class UserController {

    public function actionIndex() {
        $users = User::getAllUsersFromStorage();
        
        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.tpl', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.tpl', 
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]);
        }
    }

    public function actionSave() {
        $name = $_GET['name'] ?? null;
        $birthday = $_GET['birthday'] ?? null;

        if ($name && $birthday) {
            $user = new User($name);
            $user->setBirthdayFromString($birthday);

            $result = $user->saveToStorage();

            $render = new Render();

            if ($result) {
                return $render->renderPage(
                    'user-save-success.tpl',
                    [
                        'title' => 'Успешное сохранение',
                        'message' => 'Пользователь успешно сохранен'
                    ]
                );
            } else {
                return $render->renderPage(
                    'user-save-failure.tpl',
                    [
                        'title' => 'Ошибка сохранения',
                        'message' => 'Не удалось сохранить пользователя'
                    ]
                );
            }
        } else {
            return "Ошибка: Параметры имени и даты рождения обязательны.";
        }
    }
}