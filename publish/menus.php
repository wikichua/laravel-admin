<?php
return 
[
	'Manager' => [
		[
			'title' => 'Users',
			'url' => 'users.index',
			'permission' => 'browse-users',
		],
		[
			'title' => 'Roles',
			'url' => 'roles.index',
			'permission' => 'browse-roles',
		],
		[
			'title' => 'Permissions',
			'url' => 'permissions.index',
			'permission' => 'browse-permissions',
		],
		[
			'title' => 'Activity Logs',
			'url' => 'activitylogs.index',
			'permission' => 'browse-activitylogs',
		],
		[
			'title' => 'Settings',
			'url' => 'settings.index',
			'permission' => 'browse-settings',
		]
	],
	'Tools' => [
		[
			'title' => 'Generator',
			'url' => 'generator.get',
			'permission' => 'browse-generator',
		]
	],
	'Public' => []
];