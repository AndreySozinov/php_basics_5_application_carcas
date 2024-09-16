<?php

namespace Geekbrains\Application1;
use Geekbrains\Application1\Render;

class Application {

    private const APP_NAMESPACE = 'Geekbrains\Application1\Controllers\\';

    private string $controllerName;
    private string $methodName;

    public function run() : string {
        $routeArray = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        // Определяем имя контроллера
        $this->controllerName = isset($routeArray[0]) && $routeArray[0] !== '' 
            ? $routeArray[0] 
            : "page";
        
        $this->controllerName = self::APP_NAMESPACE . ucfirst($this->controllerName) . "Controller";

        // Проверяем существование контроллера
        if (class_exists($this->controllerName)) {
            // Определяем имя метода
            $this->methodName = isset($routeArray[1]) && $routeArray[1] !== '' 
                ? "action" . ucfirst($routeArray[1]) 
                : "actionIndex";

            // Проверяем существование метода в контроллере
            if (method_exists($this->controllerName, $this->methodName)) {
                $controllerInstance = new $this->controllerName();
                return call_user_func_array(
                    [$controllerInstance, $this->methodName],
                    [] // Здесь можно передавать параметры, если они нужны
                );
            } else {
                // Отправляем заголовок с кодом 404
                header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
                return "Метод не существует";
            }
        } else {
            // Отправляем заголовок с кодом 404
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");

            $render = new Render();
            return $render->renderPage(
                'error-page.tpl', 
                [
                    'title' => 'Ошибка 404',
                    'message' => 'Страница не найдена'
                ]
            );
        }
    }

    public function render(array $pageVariables) { 
    }
}
