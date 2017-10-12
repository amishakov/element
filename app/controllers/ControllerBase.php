<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
	public $tables;
	public $sidebarTables;
	public $extansions;
	public $extenLinks;

	public function initialize()
	{
		$config = $this->di->get('config');

		// define all database tables for output
		$this->sidebarTables = [];
		$this->tables = $this->_getTables($this->sidebarTables);
		$this->view->setVar('tables',$this->tables);
		$this->view->setVar('sidebarTables',$this->sidebarTables);

		// некоторые важнве переменные
		$this->view->setVar('baseUri',$config->application->baseUri);
		$this->view->setVar('controllerName',$this->router->getControllerName());

		$auth = $this->session->get('auth');
		$this->view->setVar('auth',$auth);

		// достаем все установленные расширения
		$extensions = $this->_getExtensions();
		// собираем ссылки левого сайдбара для расширений
		$this->extenLinks = [];
		if(count($extensions))
			foreach($extensions as $ext)
				if(!empty($ext['sidebarlinks']))
					foreach ($ext['sidebarlinks'] as $link)
						$this->extenLinks[] = $link;
		$this->view->setVar('extenLinks',$this->extenLinks);

		// свернутость сайдбара
		$sFolded = 0;
		if(isset($_COOKIE['sFolded']))
            $sFolded = $_COOKIE['sFolded'];
        $this->view->setVar('sFolded',$sFolded);
	}

	/**
	 * Возврощает все таблицы с измененными имениями
	 */
	private function _getTables(&$shownTables)
	{
		$db     = $this->di->get('db');
		$config = $this->di->get('config');

		// системные таблицы которые не нужно нигде выводить
		$systemTables = ['em_names','em_types','em_users','em_views'];

		// достаем все имена таблиц, исключаем системные
		// связываем их с другими
		$tables = [];
		$db_tables = $db->fetchAll(
			"SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_TYPE='BASE TABLE' AND TABLE_SCHEMA=:database",
			Phalcon\Db::FETCH_ASSOC,
			array('database'=>$config->database->dbname)
		);
		foreach ($db_tables as $tbl)
		{
			if(!in_array($tbl['table_name'], $systemTables))
			{
				$tables[$tbl['table_name']] = array
				(
					'table_name' => $tbl['table_name']
				);
			}
		}

		// ищем названия только для таблиц (type=0)
		$named_tables = EmNames::find(['conditions'=>"field = ''"]);
		foreach($named_tables as $key => $table)
		{
			if(array_key_exists($table->table, $tables))
			{
				$tables[$table->table]['table_name'] = $table->name;
				$tables[$table->table]['show']       = $table->show;
			}
			if($table->show == 1 && array_key_exists($table->table, $tables))
				$shownTables[$table->table] = $tables[$table->table];
		}
		return $tables;
	}


	/**
	 * Возврощает список установленных расширений
	 */
	private function _getExtensions()
	{
		global $config;
		$extensions = [];
		$files = scandir($config->application->extDir,1);
		foreach ($files as $ext)
		{
			$infoFile = $config->application->extDir.$ext.'/info.json';
			if(is_dir($config->application->extDir.$ext) && file_exists($infoFile))
			{
				$infoJSON = file_get_contents($infoFile);
				$infoJSON = json_decode($infoJSON,true);
				if(!empty($infoJSON['status']) && $infoJSON['status'] == 'installed')
					$extensions[$ext] = $infoJSON;
			}
		}

		return $extensions;
	}

	public function pageNotFound()
	{
		if($this->request->isAjax())
			return $this->jsonResult(['result'=>'error','msg'=>'not found']);	
		
		$this->response->redirect('/notfound/');
		$this->view->disable();
	}

	public function jsonResult($data)
	{
		echo json_encode($data);
		$this->view->disable();
		return;
	}

}
