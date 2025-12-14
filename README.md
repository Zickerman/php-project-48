### Hexlet tests and linter status:
[![Actions Status](https://github.com/Zickerman/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Zickerman/php-project-48/actions)

### SonarQube tests and linter status:
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Zickerman_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=Zickerman_php-project-48)

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
    make gendiff param="./tests/fixtures/nestedJson1.json ./tests/fixtures/nestedJson2.json"
with format(e.g. stylish is default value):
    make gendiff param="--format=stylish ./tests/fixtures/nestedYaml1.yaml ./tests/fixtures/nestedYaml2.yaml"
    make gendiff param="--format=plain ./tests/fixtures/nestedJson1.json ./tests/fixtures/nestedJson2.json"



#### Посмотреть работу программы (запуск команды с параметром(пути до файлов))
https://asciinema.org/a/jLLopy710lKHQsuKL4X1r7bSk

#### Посмотреть работу программы (yaml файл)
https://asciinema.org/a/L0MX3TOhGDSeo2C0oByWw9MTf

#### Посмотреть работу программы (многоуровневая вложенность)
https://asciinema.org/a/WBnPDjn8H2crd1OYTE6dCRwYk

#### Посмотреть работу программы (многоуровневая вложенность разные форматы)
https://asciinema.org/a/vf0VQWYc0vQ49iR5TzqId9qCC

#### Посмотреть работу программы (многоуровневая вложенность формат json)
https://asciinema.org/a/IGfFRUyQnMJD2MDQD1nCrLtuR