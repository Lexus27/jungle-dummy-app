<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: demo_shop
 * IDE: PhpStorm
 * Date: 08.11.2016
 * Time: 13:23
 */
namespace App\Strategies {

	use Jungle\Application\Strategy\Http\CookieManager;
	use Jungle\Application\Strategy\Http\Router;
	use Jungle\Application\View\ViewStrategy;
	use Jungle\Di\DiInterface;
	use Jungle\User\Account;
	use Jungle\User\Session\Provider\Session;
	use Jungle\User\Session\Provider\Token;
	use Jungle\User\Session\SignatureInspector\Cookies;
	use Jungle\User\Session\SignatureInspector\TokenInspector;
	use Jungle\User\SessionManager;
	use Jungle\Util\Communication\HttpFoundation\RequestInterface;
	use Services\Session\MyModels;

	/**
	 * Class Http
	 * @package Strategies
	 */
	class Http extends \Jungle\Application\Strategy\Http{
		
		/**
		 * @return void
		 */
		public function registerServices(){


			$this->setShared('router', function(){

				$router = new Router();

				$router->removeExtraRight('/');

				$router->any('/',[
					'main' => true,
					'name' => 'root',
					'reference' => [
						'controller' 	=> 'index',
						'action' 		=> 'index'
					],
					'modify' => false
				]);

				$router->any('/login',[
					'reference' => '#index:user.auth:login',
					'converter' => function($p,RequestInterface $request){
						if($request->isPost()){
							$p['login'] = $request->getPost('login');
							$p['password'] = $request->getPost('password');
						}
						return $p;
					}
				]);
				return $router;
			});



			$this->set('view_strategy', function(){
				$vs = new ViewStrategy();
				$vs->addRule('html', new ViewStrategy\RendererRule\HttpAcceptRendererRule('html'));
				$vs->addRule('json', new ViewStrategy\RendererRule\HttpAcceptRendererRule('json'));
				$vs->setDefault('html');
				return $vs;
			});

			$this->setShared('session',function(DiInterface $di){

				$manager = new SessionManager();
				$manager->setDi($di);
				$manager->setStorage(new MyModels());

				$cookieSession = new Session();
				$cookieSession->setDi($di);
				$cookieSession->setSignatureInspector( (new Cookies())->setCookieName('JUNGLE_SESS') );

				$tokenInspector = new TokenInspector('accessBy','setAccessToken','setAccessExpires');
				$token = new Token();
				$token->setDi($di);
				$token->setSignatureInspector($tokenInspector);


				$manager->setDefaultProvider($cookieSession);
				$manager->setProviders([
					$cookieSession,
					$token,
				]);


				$manager->setLifetime(86000 * 2);

				return $manager;
			});

			$this->setShared('cookie', new CookieManager());

			$this->setShared('account', new Account());


		}

	}
}

