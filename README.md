### Hexlet tests and linter status:
[![Actions Status](https://github.com/Zickerman/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Zickerman/php-project-48/actions)

execute in the console of the root directory:

  to prepare project:
  
    make prepare

  launch command:

    make gendiff 

  launch with params:

    make gendiff param=-h 

    or just:

    ./bin/gendiff -h

launch with 2 files (acceptable absolute paths in ```file_get_contents()```):

    make gendiff param="./file1.json ./file2.json"



#### Посмотреть работу программы (запуск команды с параметром(пути до файлов))
https://asciinema.org/a/jLLopy710lKHQsuKL4X1r7bSk