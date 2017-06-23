<?php
namespace Base;
class Simphp {
	public static function run()
	{
		  \Base\Structure::create(); //创建项目目录结构

		  $pathinfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
		  $urlArr = \Base\Route::parse($pathinfo); //解析url
		  //加载应用的配置文件
		  $configArr = file_exists(APP.'/config.php')  ?   require(APP.'/config.php')   : die(APP.'/config.php文件不存在:(');
		  if( !empty($configArr) ){
		  	foreach($configArr as $k=>$v){
				if(isset($k) && isset($v))
		  			define($k,$v);//这里需要对$k，$v做判断
		  	}
		  }
		  require ZENDFRAME.'/Conf/config.php';	//加载框架默认的配置文件
		  // 访问应用
		  $app    = $urlArr['app'];
		  // 访问模块名
		  $module = $urlArr['module'];
		  // 访问方法名
		  $action = $urlArr['action'];
		  $moduleName = $module.'Controller';

		  file_exists(APP.'/controller/'.$module.'.class.php')          ? require_once(APP.'/controller/'.$module.'.class.php')      : die(APP.'/controller/'.$module.'.class.php文件不存在:(');
		  if( file_exists(APP.'/model/'.     $module.'Model.class.php') ) require_once(APP.'/model/'.     $module.'Model.class.php') ;
		  $controlName = '\\Base\\Controller\\'.$moduleName;
		  $obj = new  $controlName;
		  $obj->$action();
	}


}