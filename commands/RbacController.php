<?php
namespace app\commands;
use Yii;
use yii\console\Controller;
use app\rbac\UserRoleRule;
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные
        //Создадим для примера права для доступа к админке
        $dashboard = $auth->createPermission('admin');
        $dashboard->description = 'Админ панель';
        $auth->add($dashboard);
        //Включаем наш обработчик
        $rule = new UserRoleRule();
        $auth->add($rule);
        //Добавляем роли
        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $user->ruleName = $rule->name;
        $auth->add($user);
        //Добавляем потомков
        $admin = $auth->createRole('administrator');
        $admin->description = 'Администратор';
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $dashboard);
    }
}