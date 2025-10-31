prepare:
# делаем файлы в каталоге bin исполняемыми
# и проверяем не добавлена ли папка vendor в исключения, если нет - добавляем
	chmod 755 ./bin/*
	grep -q '/vendor/' .gitignore || echo "/vendor/" >> .gitignore

# в param будет подставлено значение из param вот тут например: make gendiff param=-v
gendiff:
	@./bin/gendiff $(param)