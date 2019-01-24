<?php
return 
[
	[
		'section' => 'Resources',
		'items' => [
				[
					'title' => 'Users',
					'url' => 'users.index',
					'permission' => 'browse-admin',
				],
				[
					'title' => 'Roles',
					'url' => 'roles.index',
					'permission' => '',
				],
				[
					'title' => 'Permissions',
					'url' => 'permissions.index',
					'permission' => '',
				],
				[
					'title' => 'Activity Logs',
					'url' => 'activitylogs.index',
					'permission' => '',
				],
				[
					'title' => 'Settings',
					'url' => 'settings.index',
					'permission' => '',
				]
			]
	],
	[
		'section' => 'Tools',
		'items' => [
				[
					'title' => 'Generator',
					'url' => 'generator.get',
					'permission' => '',
				]
			]
	]
];