<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: demo_shop
 * IDE: PhpStorm
 * Date: 08.11.2016
 * Time: 14:17
 */
namespace App\Modules\Index\Controller\User {

	use App\Model\User;
	use Jungle\Application\Dispatcher\Controller;
	use Jungle\Application\Dispatcher\Process;
	use Jungle\Application\Notification\Responsible;
	use Jungle\User\AccessAuth\Auth;
	
	/**
	 * Class Auth
	 * @package App\Modules\Index\Controller\User
	 */
	class AuthController extends Controller{

		/**
		 * @param Process $process
		 * @return bool|\Jungle\Data\Record\Model
		 * @throws Responsible
		 */
		public function loginAction(Process $process){

			$account = $this->account;
			if(!$user = $account->getUser()){
				$login      = $process->requireParam('login',false);
				$password   = $process->requireParam('password',false);
				/** @var User $user */
				$user = User::findFirst(['username' => $login]);
				if($user){
					$process->setParam('user', $user);
					$auth = Auth::getAccessAuth([$login, $password]);
					if($auth->match($user->getProperty('password'))){
						$account->setUser($user);
						return [
							'user' => $user
						];
					}else{
						throw new Responsible\AuthenticationMissed('User verify error',1);
					}
				}else{
					throw new Responsible\AuthenticationMissed('User verify error 2',1);
				}
			}
			return null;
		}

		public function loginAfterControl(Process $process){
			$this->response->sendRedirect($process->linkBy('user-short',$process->user),303);
		}

		/**
		 * @param Process $process
		 * @return bool
		 */
		public function logoutAction(Process $process){
			if($this->account->getUser()){
				$this->account->setUser(null);
			}
			$this->response->sendRedirect('/',302);
			return true;
		}

	}
}

