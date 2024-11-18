<?php

$form_actions =
	[
		'form'  => function ($form_name) {
			echo "\nsMedia.Window.params.form = '$form_name';";
			echo "\nsMedia.Window.open('https://tm.smedia.ca/forms/{$form_name}.php');\n";
		}
	];

function call_form_action($params)
{
	global $form_actions;

	if (!is_array($params)) {
		$params = [$params];
	}

	$func = $params[0];
	$args = array_slice($params, 1);

	if (!key_exists($func, $form_actions)) {
		return;
	}

	call_user_func_array($form_actions[$func], $args);
}
