<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: demo_shop
 * IDE: PhpStorm
 * Date: 08.11.2016
 * Time: 13:17
 */
namespace App {
	
	use Jungle\Application\Dispatcher;
	use Jungle\Application\Reporter\CrashReporter;
	use Jungle\Application\StaticApplication;

	use Jungle\Application\View\Renderer\Data\Json;
	use Jungle\Application\View\Renderer\TemplateEngine\Php;

	use Jungle\Application\ViewInterface;
	use Jungle\Di\DiInterface;
	use Jungle\Di\DiSettingInterface;
	use Jungle\EventManager\EventManager;
	use Jungle\Loader;

	/**
	 * Class Application
	 * @package App
	 */
	class Application extends StaticApplication{

		/**
		 * @param DiInterface|DiSettingInterface $di
		 * @return mixed
		 */
		protected function registerDatabases(DiSettingInterface $di){}

		/**
		 * @param DiInterface|DiSettingInterface $di
		 * @return mixed
		 */
		protected function registerServices(DiSettingInterface $di){
			$di->setShared('event_manager',new EventManager());
			$di->setShared('crash_reporter',function(){
				return new CrashReporter($this);
			});

		}

		/**
		 * @param Loader $loader
		 */
		protected function registerAutoload(Loader $loader){}

		/**
		 * @param Dispatcher $dispatcher
		 */
		protected function initializeDispatcherSettings(Dispatcher $dispatcher){}

		/**
		 * @param ViewInterface $view
		 */
		protected function initializeViewRenderers(ViewInterface $view){
			$view->setRenderer('html', new Php('text/html'));
			$view->setRenderer('json', new Json('application/json'));
		}


	}
}

