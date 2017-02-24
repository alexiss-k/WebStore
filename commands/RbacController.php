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
        $auth->removeAll();

        $dashboard = $auth->createPermission('admin');
        $dashboard->description = 'Админ панель';
        $auth->add($dashboard);
        
        $rule = new UserRoleRule();
        $auth->add($rule);
        
        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $user->ruleName = $rule->name;
        $auth->add($user);
        
        $admin = $auth->createRole('administrator');
        $admin->description = 'Администратор';
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $dashboard);
    }
}