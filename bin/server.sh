#!/bin/sh

php app/console youfood:server --port=16350 --host="`/sbin/ifconfig | grep -E "inet " | grep -Eo "([0-9]+\.?)+" | head -n 1`"