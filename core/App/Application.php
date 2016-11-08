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
	
	use App\Services\AccessControl\Context;
	use Jungle\Application\Access\ExpressionResolver;
	use Jungle\Application\Dispatcher;
	use Jungle\Application\Reporter\CrashReporter;
	use Jungle\Application\StaticApplication;

	use Jungle\Application\View\Renderer\Data\Json;
	use Jungle\Application\View\Renderer\TemplateEngine\Php;

	use Jungle\Application\ViewInterface;
	use Jungle\Di\DiInterface;
	use Jungle\Di\DiSettingInterface;
	use Jungle\Di\Injectable;
	use Jungle\EventManager\EventManager;
	use Jungle\Loader;
	use Jungle\User\AccessControl\Manager;
	use Jungle\User\AccessControl\Matchable\Aggregator\MemoryBuilder\Memory;
	use Jungle\User\AccessControl\Matchable\Combiner;
	use Jungle\User\AccessControl\Matchable\Matchable;

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



			$di->setShared('access',function($di){
				$manager = new Manager();
				$combiner_set = $this->getCombinersSet();

				$defaultC = null;
				if(isset($combiner_set['default'])){
					$defaultC = $combiner_set['default'];
					unset($combiner_set['default']);
				}

				$mainC = null;
				if(isset($combiner_set['main'])){
					$mainC = $combiner_set['main'];
					unset($combiner_set['main']);
				}

				foreach($combiner_set as $combinerKey => $definition){
					$manager->setCombiner($combinerKey,  new Combiner($definition));
				}

				$manager->setDefaultCombiner($defaultC);
				$manager->setMainCombiner($mainC);

				$accessDefinition = $this->getAccessPolicies();
				$manager->setDefaultEffect($accessDefinition['default_effect']);
				$manager->setSameEffect($accessDefinition['same_effect']);

				$aggregator = new Memory('main');
				$aggregator->build($accessDefinition);
				$manager->setAggregator($aggregator);
				$manager->setExpressionResolver(new ExpressionResolver($this));
				$context = new Context();
				$context->setDi($di);
				$manager->setContext($context);
				return $manager;
			});


		}


		/**
		 * @return array
		 */
		protected function getCombinersSet(){
			return [
				'default' => 'dispute_all',

				'main' => 'dispute_all',



				'delegate' => [
					'default' => 'not_applicable',
					'applicable' => [
						'early'     => true,
						'effect'    => '{current}'
					],
				],

				'delegate_same' => [
					'default' => '{same}',
					'applicable' => [
						'early'     => true,
						'effect'    => '{current}'
					],
				],

				'dispute' => [
					'default'   => '{same}',
					'empty'     => '{same}',
					'applicable' => [
						'check'     => '{!same}',
						'early'     => true,
						'effect'    => '{current}'
					],
				],
				'dispute_all' => [
					'default'   => '{same}',
					'empty'     => '{same}',
					'applicable' => [
						'check' => [[
							'check'     => '{!same}',
							'effect'    => '{current}'
						],[
							'check'     => '{same}',
							'early'     => true,
							'effect'    => '{current}'
						]]
					],
				],


				'permit_by_permit' => [
					'return_only'   => 'permit',
					'default'       => 'not_applicable',
					'empty'         => 'not_applicable',
					'deny'          => [
						'early'         => true,
						'effect'        => 'not_applicable'
					],
					'permit'        => [
						'effect'        => '{current}'
					],
				],

				'deny_by_deny' => [
					'return_only'   => 'deny',
					'default'       => 'not_applicable',
					'empty'         => 'not_applicable',
					'deny'          => [
						'effect'        => '{current}'
					],
					'permit'        => [
						'early'         => true,
						'effect'        => 'not_applicable'
					],
				],


				'same_by_same' => [
					'default'       => 'not_applicable',
					'empty'         => 'not_applicable',
					'applicable' => [
						'check'     => [[
							'check'     => '{!same}',
							'early'     => true,
							'effect'    => 'not_applicable'
						],[
							'check'     => '{same}',
							'effect'    => '{same}'
						]]
					],
				],

				'same' => [

					'default'   => '{same}',
					'empty'     => '{same}',
					'applicable' => [
						'check'     => '{!same}',
						'early'     => true,
						'effect'    => '{current}'
					],

				],

				'same_only' => [
					'default'=> '{same}',
					'not_applicable' => [
						'effect'    => '{current}'
					],
					'applicable' => [
						'check'     => '{!same}',
						'early'     => true,
						'effect'    => '{current}'
					]
				],

			];
		}

		protected function getAccessPolicies(){
			return [

				'default_effect' => Matchable::PERMIT,
				'same_effect' => Matchable::DENY,

				'policies' => [[
					'effect' => false,
					'name' => 'MCA',

					'target' => [
						'all_of' => '[object::class] = MCA'
					],
					'combiner' => 'dispute_all',

					'rules' => [[
						'effect' => true,
						'target' => [
							'any_of' => [
								'[object.mca] = #index:index:not_found',
								'[object.mca] = #index:index:error',
								'[object.mca] = #index:index:denied',
								'[object.mca] = #index:index:index',
							]
						]
					]]
				]]
			];
		}

		/**
		 * @param $di
		 * @return ViewInterface
		 */
		protected function initializeView($di){
			$view  = parent::initializeView($di);
			$view->setVar('services',$this->_dependency_injection);
			return $view;
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

