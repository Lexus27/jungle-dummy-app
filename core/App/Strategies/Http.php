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

	use Jungle\Util\Communication\HttpFoundation\RequestInterface;
	use Jungle\Application\Strategy\Http\CookieManager;
	use Jungle\Application\Strategy\Http\Router;
	use Jungle\Application\View\ViewStrategy;
	use Jungle\Di\DiInterface;
	use Jungle\User\Account;

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
				$router->notFound('#index:index:not_found');
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

				$manager = new \Jungle\User\SessionManager();
				$manager->setDi($di);
				$manager->setStorage(new \App\Services\Session\MyModels());

				// our session manager
				$mySessionProvider = new \Jungle\User\Session\Provider\Session();
				$mySessionProvider->setDi($di);

				// inspect session signature from request by Cookies
				$cookieInspector = new \Jungle\User\Session\SignatureInspector\Cookies();
				$cookieInspector->setCookieName('JUNGLE_SESS');
				$mySessionProvider->setSignatureInspector($cookieInspector);

				// other API Token specify intercepting
				$myTokenSessProvider = new \Jungle\User\Session\Provider\Token();
				$myTokenSessProvider->setDi($di);
				// inspect token signature from request by special token inspector (inspect by get/post/json-object params automatically)
				$tokenInspector = new \Jungle\User\Session\SignatureInspector\TokenInspector(
					'accessBy','setAccessToken','setAccessExpires'
				);
				$myTokenSessProvider->setSignatureInspector($tokenInspector);


				// mount to manager with default
				$manager->setDefaultProvider($mySessionProvider);
				$manager->setProviders([
					$mySessionProvider,
					$myTokenSessProvider,
				]);

				// set sessions lifetime, if NULL - will be removed after close client browsing session
				$manager->setLifetime(86000 * 2);

				return $manager;
			});

			/**
			 * Cookie Manager from request
			 */
			$this->setShared('cookie', new CookieManager());

			/**
			 * Account read the session for recognize logged User identifiers
			 */
			$this->setShared('account', new Account());


		}

	}
}

