<?php
namespace App\Modules;
use Jungle\Application\Dispatcher\Module\StaticModule;
use Jungle\Application\Dispatcher\ProcessInterface;

/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: demo_shop
 * IDE: PhpStorm
 * Date: 08.11.2016
 * Time: 13:04
 */
class Index extends StaticModule{


	protected function interceptedException(\Exception $e, ProcessInterface $process){
		if($process->getTask('access')){
			$process->forward('#index:index:denied');
		}
	}

}

