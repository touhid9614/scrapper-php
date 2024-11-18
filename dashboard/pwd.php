<?php

/**
 * It must contain between 8 and 32 characters. Use only characters from the following set: 
 * ! # $ % & ( ) * + , - . / 0123456789 : ; < = > ? @ ABCDEFGHIJKLMNOPQRSTUVWXYZ [ \ ] _ `abcdefghijklmnopqrstuvwxyz { | } ~
 * It must contain at least 1 capital letter(s) (ABCDEFGHIJKLMNOPQRSTUVWXYZ).
 * It must contain at least 1 numeric character(s) (0123456789).
 * It must not contain more than 2 identical consecutive characters (AAA, iiii, $$$$$ ...).
 * It must not contain your user name.
 * It must not contain your email address.
 * It must not contain your first name.
 * It must not contain your last name.
 *
 * @param      <type>  $password  The password
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function password_strength($password = null, $min_len = 8, $max_len = 64) 
{
	$pass_reg = '/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{' . $min_len .',' . $max_len . '}$/';

	if (!preg_match($pass_reg, $password)) 
	{
		return false;
	}

	return true;
}

?>
<!-- 
The following regex ensures at least one lowercase, uppercase, number, and symbol exist in a 8+ character length password:


^ Assert position at the start of the line.
(?=\P{Ll}*\p{Ll}) Ensure at least one lowercase letter (in any script) exists.
(?=\P{Lu}*\p{Lu}) Ensure at least one uppercase letter (in any script) exists.
(?=\P{N}*\p{N}) Ensure at least one number character (in any script) exists.
(?=[\p{L}\p{N}]*[^\p{L}\p{N}]) Ensure at least one of any character (in any script) that isn't a letter or digit exists.
[\s\S]{8,} Matches any character 8 or more times.
$ Assert position at the end of the line. -->


We use this function when we change application wise $algo or its relevant $options.

<?php

$new = [
    'options' => ['cost' => 11],
    'algo' => PASSWORD_DEFAULT,
    'hash' => null
];

$password = 'rasmuslerdorf';

//generated hash of password
$oldHash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';

//first we verify stored hash against plain-text password
if (true === password_verify($password, $oldHash)) {
    // verify legacy password to new password_hash options
    if (true === password_needs_rehash($oldHash, $new['algo'], $new['options'])) {
        // rehash/store plain-text password using new hash
        $newHash = password_hash($password, $new['algo'], $new['options']);
        echo $newHash;
    }
}
?>

The above example will output something similar to:
$2y$11$Wu5rN3u38.g/XWdUeA6Wj.PD.F0fLXXmZrMNFyzzg2UxkVmxlk41W