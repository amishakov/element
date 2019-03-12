<?php
class TableWorkerCest
{
	public function dbConfig(ApiTester $I)
	{
		$I->sendPOST('http://element.dev2.odva.pro/element/install.php', ['host' => 'localhost', 'username' => 'root', 'password' => 'Hi8R28XY|P', 'adapter' => 'Mysql']);
		$I->seeResponseCodeIs(200);
		if(file_exists(__DIR__ . "/../app/config/config.php"))
		{
			$I->seeResponseContainsJson(['success' => false]);
		}
		else
		{
			$I->seeResponseContainsJson(['success' => true]);
		}
		$I->sendPOST('http://element.dev2.odva.pro/element/install.php', ['host' => 'dda', 'username' => 'f', 'password' => 'Hi8R28XY|P', 'adapter' => 'Mysql']);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendPOST('http://element.dev2.odva.pro/element/install.php', ['host' => 'dda', 'username' => 'f', 'adapter' => 'Mysql']);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);
	}

	public function getTables(ApiTester $I)
	{
		$I->sendPOST('/auth/', ['login' => 'admin', 'password' => 'adminpass']);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/getTables');
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		$I->seeResponseContainsJson(['success' => true]);
		$I->seeResponseJsonMatchesJsonPath('$.tables.*.code');
		$I->seeResponseJsonMatchesJsonPath('$.tables.*.name');
		$I->seeResponseJsonMatchesJsonPath('$.tables.*.tviews');
		$I->seeResponseJsonMatchesJsonPath('$.tables.*.tviews.*.filter');
		$I->seeResponseJsonMatchesJsonPath('$.tables.*.tviews.*.sort');
		$I->seeResponseJsonMatchesJsonPath('$.tables.*.tviews.*.settings');
		$I->seeResponseJsonMatchesJsonPath('$.tables.*.tviews.*.id');
		$I->seeResponseJsonMatchesJsonPath('$.tables.*.tviews.*.table');
		$I->seeResponseJsonMatchesJsonPath('$.tables.*.tviews.*.name');
		$I->seeResponseJsonMatchesJsonPath('$.tables.*.tviews.*.default');
	}

	public function getColumns(ApiTester $I)
	{
		$I->sendPOST('/auth', ['login' => 'admin', 'password' => 'adminpass']);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/getColumns', ['tableName' => 'products']);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);
		$I->seeResponseJsonMatchesJsonPath('$.columns.*.field');
		$I->seeResponseJsonMatchesJsonPath('$.columns.*.type');
		$I->seeResponseJsonMatchesJsonPath('$.columns.*.null');
		$I->seeResponseJsonMatchesJsonPath('$.columns.*.key');
		$I->seeResponseJsonMatchesJsonPath('$.columns.*.default');
		$I->seeResponseJsonMatchesJsonPath('$.columns.*.extra');

		$I->seeResponseJsonMatchesJsonPath('$.columns.*.em.type');
		$I->seeResponseJsonMatchesJsonPath('$.columns.*.em.settings');
		$I->seeResponseJsonMatchesJsonPath('$.columns.*.em.required');
		$I->seeResponseJsonMatchesJsonPath('$.columns.*.em.type_info');

		$I->sendPOST('/el/getColumns', ['tableName' => 'asdsad']);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendPOST('/el/getColumns');
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);
	}

	public function select(ApiTester $I)
	{
		$I->sendPOST('/auth/', ['login' => 'admin', 'password' => 'adminpass']);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendGET('/el/select',
		[
			'select' =>
			[
				'fields' => ['n? +ame', 'id', 'col'],
				'from' => 'testTable',
				'where' =>
				[
					'operation' => 'and',
					'fields' =>
					[
						[
							'code' => 'jil',
							'operation' => 'IS',
							'value' => 'aa'
						],
						[
							'code' => 'jil2',
							'operation' => 'IS NOT',
							'value' => 'ff'
						],
						[
							'operation' => 'or',
							'fields' =>
							[
								[
									'code' => 'jil2',
									'operation' => 'CONTAINS',
									'value' => 'fa'
								],
								[
									'code' => 'jil2',
									'operation' => 'START WITH',
									'value' => 'fa'
								]
							]
						]
					]
				],
				'order' => ['name DESC']
			]
		]);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendGET('/el/select',
		[
			'select' => ['from' => 'testTable']
		]);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');

		$I->sendGET('/el/select',
		[
			'select' =>
			[
				'fields' => ['name', 'id', 'col'],
				'from' => 'testTable'
			]
		]);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');

		$I->sendGET('/el/select',
		[
			'select' =>
			[
				'fields' => ['name', 'id'],
				'from' => 'testTable',
				'where' =>
				[
					'operation' => 'and',
					'fields' =>
					[
						[
							'code' => 'name',
							'operation' => 'IS',
							'value' => 'eee'
						],
						[
							'code' => 'email',
							'operation' => 'CONTAINS',
							'value' => '3'
						],
						[
							'operation' => 'or',
							'fields' =>
							[
								[
									'code' => 'avat',
									'operation' => 'IS EMPTY'
								]
							]
						]
					]
				],
				'order' => ['name DESC']
			]
		]);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');

		$I->sendGET('/el/select',
		[
			'select' =>
			[
				'fields' => ['name', 'id'],
				'from' => 'testTable',
				'where' =>
				[
					'operation' => 'and',
					'fields' =>
					[
						[
							'code' => 'name',
							'operation' => 'IS',
							'value' => 'eee'
						],
						[
							'code' => 'email',
							'operation' => 'DOES NOT CONTAIN',
							'value' => '3'
						],
						[
							'operation' => 'or',
							'fields' =>
							[
								[
									'code' => 'avat',
									'operation' => 'IS',
									'value' => '3'
								]
							]
						]
					]
				],
				'order' => ['name DESC']
			]
		]);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');

		$I->sendGET('/el/select',
		[
			'select' =>
			[
				'fields' => ['name', 'id'],
				'from' => 'testTable',
				'where' =>
				[
					'operation' => 'and',
					'fields' =>
					[
						[
							'code' => 'col',
							'operation' => 'IS',
							'value' => '4'
						]
					]
				]
			]
		]);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');

		$I->sendGET('/el/select');
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendGET('/el/select',
		[
			'select' =>
			[
				'fields' => ['name', 'id', 'col'],
				'from' => 'testTable',
				'where' =>
				[
					'operation' => 'and',
					'fields' =>
					[
						[
							'code' => 'col',
							'operation' => 'IS',
							'value' => '4'
						]
					]
				]
			]
		]);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');

		$I->sendGET('/el/select',
		[
			'select' =>
			[
				'from' => 'testTable'
			]
		]);
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
		$I->seeResponseJsonMatchesJsonPath('$.result.items');
	}

	public function update(ApiTester $I)
	{
		$I->sendPOST('/auth/', ['login' => 'admin', 'password' => 'adminpass']);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/update/',
		[
			'update' =>
			[
				'table' => 'testTable',
				'set' =>
				[
					'email = 3',
					'col = 5'
				],
				'where' =>
				[
					'operation' => 'and',
					'fields' =>
					[
						[
							'code' => 'name',
							'operation' => 'IS',
							'value' => 'eee'
						],
						[
							'code' => 'email',
							'operation' => 'DOES NOT CONTAIN',
							'value' => '3'
						],
						[
							'operation' => 'or',
							'fields' =>
							[
								[
									'code' => 'avat',
									'operation' => 'IS',
									'value' => '3'
								]
							]
						]
					]
				],
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/update/',
		[
			'update' =>
			[
				'table' => 'testTable',
				'set' =>
				[
					"email = 'rrrrr'",
					"col = '222222'"
				],
				'where' =>
				[
					'operation' => 'and',
					'fields' =>
					[
						[
							'code' => 'id',
							'operation' => 'IS',
							'value' => 2
						]
					]
				]
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/update/',
		[
			'update' =>
			[
				'table' => 'testTable',
				'set' =>
				[
					"name = 'ggапфффыввфывg'",
				],
				'where' =>
				[
					'operation' => 'and',
					'fields' =>
					[
						[
							'code' => 'name',
							'operation' => 'CONTAINS',
							'value' => 'ggg'
						],
						[
							'operation' => 'or',
							'fields' =>
							[
								[
									'code' => 'avat',
									'operation' => 'IS',
									'value' => '3'
								]
							]
						]
					]
				]
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/update/',
		[
			'update' =>
			[
				'table' => 'testTable'
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendPOST('/el/update/',
		[
			'update' => []
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendPOST('/el/update/');

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);
	}

	public function insert(ApiTester $I)
	{
		$I->sendPOST('/auth/', ['login' => 'admin', 'password' => 'adminpass']);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/insert/',
		[
			'insert' =>
			[
				'table' => 'testTable',
				'columns' =>
				[
					'name', 'email', 'col', 'avat'
				],
				'values' =>
				[
					'"11"', '"qwe"', '"222222"', '"222211211"'
				]
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/insert/',
		[
			'insert' =>
			[
				'table' => 'testTable',
				'columns' =>
				[
					'name', 'avat'
				],
				'values' =>
				[
					'"11"', '"qwe"', '"222222"', '"222211211"'
				]
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendPOST('/el/insert/',
		[
			'insert' =>
			[
				'table' => 'testTable',
				'values' =>
				[
					'"33"', '"qwe"', '"222222"', '"222211211"'
				]
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendPOST('/el/insert/',
		[
			'insert' =>
			[
				'table' => 'testTable',
				'values' =>
				[
					'"44"'
				]
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendPOST('/el/insert/',
		[
			'insert' =>
			[
				'table' => 'testTable'
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendPOST('/el/insert/',
		[
			'insert' => []
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendPOST('/el/insert/');

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);
	}

	public function delete(ApiTester $I)
	{
		$I->sendPOST('/auth/', ['login' => 'admin', 'password' => 'adminpass']);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/delete/',
		[
			'delete' =>
			[
				'table' => 'testTable',
				'where' =>
				[
					'operation' => 'and',
					'fields' =>
					[
						[
							'code' => 'name',
							'operation' => 'CONTAINS',
							'value' => 'ggg'
						]
					]
				]
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/delete/',
		[
			'delete' =>
			[
				'table' => 'testTable',
				'where' =>
				[
					'operation' => 'or',
					'fields' =>
					[
						[
							'code' => 'name',
							'operation' => 'CONTAINS',
							'value' => 'ggg'
						],
						[
							'code' => 'email',
							'operation' => 'IS',
							'value' => '1'
						]
					]
				]
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/delete/',
		[
			'delete' =>
			[
				'table' => 'testTable'
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/delete/',
		[
			'delete' => []
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);

		$I->sendPOST('/el/delete/');

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);
	}

	public function setTviewSettings(ApiTester $I)
	{
		$I->sendPOST('/auth/', ['login' => 'admin', 'password' => 'adminpass']);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/setTviewSettings/',
		[
			'tviewId' => '3',
			'params' =>
			[
				'columns' =>
				[
					'id' => [ 'width' => 300 ],
					'name' => [ 'width' => 600 ]
				]
			]
		]);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => true]);

		$I->sendPOST('/el/setTviewSettings/', []);

		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson(['success' => false]);
	}
}