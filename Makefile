prepare:
# делаем файлы в каталоге bin исполняемыми
# и проверяем не добавлена ли папка vendor в исключения, если нет - добавляем
	chmod 755 ./bin/*
	grep -q '/vendor/' .gitignore || echo "/vendor/" >> .gitignore

lint:
# проверка кода на корректность типов, синтаксиса и.т.д
# значение level чем выше - тем строже проверка
	@vendor/bin/phpstan analyse src --level=5

test:
# запуск тестов
	@./vendor/bin/phpunit --verbose
test-coverage:
	@mkdir -p build/logs
	@XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover=build/logs/clover.xml


# в param будет подставлено значение из param вот тут например: make gendiff param=-v в том числе форматер, пути к файлам и.т.д.
gendiff:
	@./bin/gendiff $(param)