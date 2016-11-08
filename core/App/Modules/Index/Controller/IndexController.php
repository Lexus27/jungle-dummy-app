<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: demo_shop
 * IDE: PhpStorm
 * Date: 08.11.2016
 * Time: 13:16
 */
namespace App\Modules\Index\Controller {
	
	use Jungle\Application\Dispatcher\Controller;
	use Jungle\Application\Dispatcher\Process;
	use Jungle\Application\Dispatcher\ProcessInterface;
	use Jungle\Util\Communication\HttpFoundation\ResponseInterface;

	/**
	 * Class IndexController
	 * @package App\Module\Index\Controller
	 */
	class IndexController extends Controller{

		/**
		 * @param Process $process
		 * @return int
		 */
		public function indexAction(Process $process){}


		/**
		 * @return array
		 */
		public function errorMetadata(){
			return [
				'hierarchy' => true,
				'private' => true
			];
		}

		/**
		 * @param Process $process
		 * @return string
		 */
		public function errorAction(Process $process){
			$response = $this->response;
			if( $response instanceof ResponseInterface ){
				$response->setCode(500);
			}
			return 'Internal server error';
		}

		/**
		 * @return array
		 */
		public function deniedMetadata(){
			return [
				'hierarchy' => true,
				'private' => true
			];
		}

		/**
		 * @param Process $process
		 * @return string
		 */
		public function deniedAction(Process $process){
			$response = $this->response;
			if( $response instanceof ResponseInterface ){
				$response->setCode(403);
			}
		}


	}
}

