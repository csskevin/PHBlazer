.PHONY=build server watch deploy clean

build:
	cd ./src && composer install
	php ./src/index.php

server:
	python -m http.server -d ./dist

watch:
	while inotifywait -qr -e modify content/ public/ template/; do \
		php ./src/index.php; \
	done

clean:
	cd ./src && composer clear
	rm -rf ./dist
