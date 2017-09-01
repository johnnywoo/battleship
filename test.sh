#!/bin/bash
set -e

if [ "x$1" = "x-h" ]; then
    echo "Usage: test.sh [http://127.0.0.1:1212]" >&2
    echo "If you do not provide API url, we will try to start a temporary development server." >&2
    exit
fi

BSAPI="$1" ./vendor/bin/phpunit --color
