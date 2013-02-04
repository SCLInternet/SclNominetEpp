phpunit
PHPUNIT=$?

vendor/bin/phpcs --standard=psr2 src
PHPCS=$?

vendor/bin/phpmd src text codesize
PHPMD=$?

EXIT=0

if [[ "$PHPUNIT" -ne "0" ]]; then
    echo "Unit tests failed"
    EXIT=1
fi
if [[ "$PHPCS" -ne "0" ]]; then
    echo "Coding standards failed"
    EXIT=1
fi
if [[ "$PHPCS" -ne "0" ]]; then
    echo "Mess detection failed"
    EXIT=1
fi

exit $EXIT
