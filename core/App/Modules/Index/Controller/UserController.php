<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: demo_shop
 * IDE: PhpStorm
 * Date: 08.11.2016
 * Time: 14:17
 */
namespace App\Modules\Index\Controller {
	
	use Jungle\Application\Dispatcher\Controller;
	use Jungle\Application\Dispatcher\Process;

	/**
	 * Class UserController
	 * @package Module\Index\Controller
	 */
	class UserController extends Controller{

		/**
		 * @param Process $process
		 * @return \Jungle\User\UserInterface|null
		 */
		public function indexAction(Process $process){
			return $this->account->getUser();
		}

	}
}

