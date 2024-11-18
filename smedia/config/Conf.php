<?php

namespace sMedia\Config;

define("SM_ROOT_DIR", dirname(dirname(__DIR__)));
define("SM_ADWORDS_DIR", SM_ROOT_DIR . "/adwords3");
define("SM_DATA_DIR", SM_ADWORDS_DIR . "/data");
define("SM_GOOGLE_TOKEN_PATH", SM_DATA_DIR . "/google-tokens.dat");

class Conf
{
	const ROOT_DIR = SM_ROOT_DIR;
	const ADWORDS_DIR = SM_ADWORDS_DIR;
	const DATA_DIR = SM_DATA_DIR;
	const GOOGLE_TOKEN_PATH = SM_GOOGLE_TOKEN_PATH;
}
