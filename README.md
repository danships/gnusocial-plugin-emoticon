#Introduction

A plugin for [gnusocial](http://gnu.io/social/) which, when enabled, converts emoji's to their respective images.

Parses both a set of UTF-8 characters, and some well-known emotions characters (:-), :-(, for example).

#Installation

Place the _Emoticons_ directory in the _local_ or _local/plugins_ folder of your gnusocial installation. Add the
following line to your _config.php_.

	addPlugin('Emoticon');
	
#Credits

Uses the [php-emoji](https://github.com/iamcal/php-emoji) library for the conversion.