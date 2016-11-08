<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 19.06.2016
 * Time: 22:43
 */
namespace App\Model {

	use Jungle\Data\Record\Head\Schema;
	use Jungle\Data\Record\Model;
	use Jungle\User\UserInterface;

	/**
	 * Class User
	 * @package App\Model
	 *
	 * @property int            $id
	 * @property string         $username
	 * @property string         $password
	 */
	class User extends Model implements UserInterface{

		/** @var  string */
		protected $id;

		/** @var  string */
		protected $username;

		/** @var  string */
		protected $password;

		/** @var  string */
		protected $salt;

		/**
		 * @return string
		 */
		public function getSource(){
			return 'ex_user';
		}

		/**
		 * @return bool
		 */
		public function getAutoInitializeProperties(){
			return true;
		}

		/**
		 * @param Schema $schema
		 */
		public static function initialize(Schema $schema){
			$schema->field('id',[
				'type' => 'integer',
			    'readonly' => true,
			]);
			$schema->field('username');
			$schema->field('password',[
				'original_key'  => 'password_hash' ,
			    'enumerable'    => false
			]);
		}

		/**
		 * @return mixed
		 */
		public function getId(){
			return $this->id;
		}

		/**
		 * @return mixed
		 */
		public function getUsername(){
			return $this->username;
		}
	}
}