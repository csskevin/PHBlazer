.PHONY=build server watch deploy

build:
	php ./src/index.php

server:
	python -m http.server -d ./dist

watch:
	while inotifywait -qr -e modify content/ public/ template/; do \
		php ./src/index.php; \
	done
