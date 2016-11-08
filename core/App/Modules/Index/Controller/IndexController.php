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

	/**
	 * Class IndexController
	 * @package App\Module\Index\Controller
	 */
	class IndexController extends Controller{

		/**
		 * @param Process $process
		 * @return int
		 */
		public function indexAction(Process $process){
			return 1;
		}

	}
}

