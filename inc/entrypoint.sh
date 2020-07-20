#!/bin/sh
echo "Hell\o from entrypoint !";

cp -r /composer/vendor /app
rm -rf /composer

exec "$@"
exec "apache2-foreground"