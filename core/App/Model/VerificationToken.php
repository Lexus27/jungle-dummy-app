<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 27.10.2016
 * Time: 12:25
 */
namespace App\Model {

	use Jungle\Data\Record;
	use Jungle\Data\Record\Model;
	use Jungle\User\Verification\TokenInterface;

	/**
	 * Class VerificationToken
	 * @package App\Model
	 */
	class VerificationToken extends Model implements TokenInterface{

		/** @var  int */
		protected $id;

		/** @var  string */
		protected $verification_key;

		/** @var  string */
		protected $scope_key;

		/** @var  string */
		protected $code;

		/** @var  array */
		protected $data;


		protected $invoke_time;

		protected $satisfy_time;


		/** @var   */
		protected $satisfied = false;



		protected $user_id;

		protected $session_id;


		public function getSource(){
			return 'ex_verification';
		}

		/**
		 * @return array
		 */
		public function getAutoInitializeProperties(){
			return true;
		}

		/**
		 * @param Record\Head\Schema $schema
		 * @throws \Exception
		 */
		public static function initialize(Record\Head\Schema $schema){
			$schema->field('id');
			$schema->field('verification_key');
			$schema->field('scope_key');
			$schema->field('code');

			$schema->field('data',[
				'type' => 'serialized',
				'nullable' => false,
				'default' => []
			]);
			$schema->field('invoke_time',[
				'type' => 'date',
				'nullable' => false,
			]);
			$schema->field('satisfy_time',[
				'type' => 'date',
				'nullable' => true,
			]);

			$schema->field('satisfied',[
				'type' => 'bool',
				'nullable' => false,
				'default' => false
			]);

			$schema->field('user_id',[
				'type' => 'int',
				'nullable' => true,
				'default' => null,
			]);
			$schema->field('session_id',[
				'type' => 'int',
				'nullable' => true,
				'default' => null,
			]);

		}


		/**
		 * @param $verification_key
		 * @return mixed
		 */
		public function setVerificationKey($verification_key){
			$this->verification_key =$verification_key;
			return $this;
		}

		/**
		 * @return string
		 */
		public function getVerificationKey(){
			return $this->verification_key;
		}

		/**
		 * @param $scope_key
		 * @return mixed
		 */
		public function setScopeKey($scope_key){
			$this->scope_key = $scope_key;
			return $this;
		}

		/**
		 * @return string
		 */
		public function getScopeKey(){
			return $this->scope_key;
		}

		/**
		 * @param $user_id
		 * @return $this
		 */
		public function setUserId($user_id){
			$this->user_id = $user_id;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getUserId(){
			return $this->user_id;
		}

		/**
		 * @param $session_id
		 * @return $this
		 */
		public function setSessionId($session_id){
			$this->session_id = $session_id;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getSessionId(){
			return $this->session_id;
		}

		/**
		 * @param null $time
		 * @return $this
		 */
		public function setInvokeTime($time = null){
			$this->invoke_time = $time;
		}

		/**
		 * @return mixed
		 */
		public function getInvokeTime(){
			return $this->invoke_time;
		}

		/**
		 * @param bool $satisfied
		 * @param null $time
		 * @return $this
		 */
		public function setSatisfied($satisfied = true, $time = null){
			$this->satisfied = $satisfied;
			if($satisfied){
				$this->satisfy_time = $time?:time();
			}else{
				$this->satisfy_time = null;
			}
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getSatisfyTime(){
			return $this->satisfy_time;
		}

		/**
		 * @return bool
		 */
		public function isSatisfied(){
			return $this->satisfied;
		}

		/**
		 * @param $code
		 * @return mixed
		 */
		public function setCode($code){
			$this->code = $code;
			return $this;
		}

		/**
		 * @return string
		 */
		public function getCode(){
			return $this->code;
		}

		/**
		 * @param array $data
		 * @return mixed
		 */
		public function setData(array $data){
			$this->data = $data;
			return $this;
		}

		/**
		 * @return array
		 */
		public function getData(){
			return $this->data?:[];
		}
	}
}

