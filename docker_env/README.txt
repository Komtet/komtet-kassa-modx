komtet_kassa_modx
===============================

Чтобы развернуть окружение и потестировать плагин в docker контейнере:
1. создать в дирректории docker_env папку /php, скопировать в нее текущий установщик ModX
2. создать папку для хранения данных БД /data/mysql
3. выполнить docker-compose up -d
4. выполнить docker-compose exec web bin/bash и создать папки с правами 777:
  - /var/www/html/core/export
  - /var/www/html/core/cache
  - /var/www/html/assets/
  - /var/www/html/assets/components/
5. для новой установки создать пустой файл с именем config.inc.php в каталоге /var/www/html/core/config/ с правами 777
6. перейти в браузере на localhost:8100/setup и выполнить установку CMS
  - Параметры подключения к БД указать:
    host: mysql,
    user: root,
    password: my_secret_pw_shh,
    db: test_db
  - Кодировку указать:
    Кодировка подключения: utf8
    Сопоставление: utf8_general_ci
7. загрузить и установить minishop2:
  - https://modx.com/extras/package/minishop2 (загрузить в пункт меню "пакеты", далее стрелочка на зеленой кнопке)
  - https://docs.modx.pro/komponentyi/minishop2/byistryij-start
8. установить и настроить плагин (иконка с шестерней, далее "системные настройки", далее в фильтре выбрать "komtetkassa")
