#!/usr/bin/env sh
cd "$(dirname "$0")/.."

cp ./tests/php-unix.ini ./tests/php.ini
PHP_EXT=`php -r "echo ini_get('extension_dir');"`
echo "" >> ./tests/php.ini # empty line
echo "extension_dir=$PHP_EXT" >> ./tests/php.ini

if [ "$1" = "" ]; then
    TESTS_DIR="./tests/"
else
    TESTS_DIR="$1"
fi

./vendor/bin/tester "$TESTS_DIR" -p php -c ./tests

exit "$?"
