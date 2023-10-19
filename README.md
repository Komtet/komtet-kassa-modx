# Способы установки
1. Путем добавления репозитория https://modstore.pro в менеджерской части своего modx и установки менеджером пакетов.
2. Путем копирования папки komtetkassa в корневую директорию modx и перехода по урле http://адрессайта/komtetkassa/_build/build.transport.php, при этом будет создан транспортный пакет в директории /core/packages
3. Путем установки через транспортный пакет в менеджерской части сайта

# Описание основных файлов и директорий

**/komtetkassa/core/components/komtetkassa/elements/plugins/plugin.komtetkassa.php** - плагин компонента, перехватывающий события для отправки заказа на фискализацию и получения отчетов о фискализации от сервиса КОМТЕТ Касса.

**/komtetkassa/core/components/komtetkassa/processors/mgr/orders/getlist.class.php** - процессор, общающийся с моделью и задающий вид выводимого списка отчетов о фискализации

**/komtetkassa/core/components/komtetkassa/controllers/mgr/orderstatus.class.php** - контроллер, задающий параметры и вид страницы списка отчетов о фискализации

**/komtetkassa/core/components/komtetkassa/model/komtetkassafiscalizer.class.php** - основная модель компонента, работающая с его настройками и имеющая метод для сборки чека на фискализацию

**/komtetkassa/core/components/komtetkassa/sdk/** - основная библиотека по работе с КОМТЕТ Кассой


**/komtetkassa/assets/components/komtetkassa/** - статика, коннекторы, экшоны


**/komtetkassa/_build/** - директория с конфигурациями для сборки и установки пакета

**/komtetkassa/_build/data/** - задает модули, которыми будет обладать компонент

**/komtetkassa/_build/resolvers/resolve.tables.php** - создает и удаляет таблицы БД при установке и удалении компонента

**/komtetkassa/_build/schema/komtetkassa.mysql.schema.xml** - описывает схему таблиц БД

**/komtetkassa/_build/build.config.php** - общая конфигурация пакета

**/komtetkassa/_build/build.schema.php** - конфигурация, задающая файлы конфигурации таблиц БД, с которыми необходимо работать

**/komtetkassa/_build/build.transport.php** - конфигурация, задающая параметры создания транспортного пакета


*(лог ошибок находится в /core/cache/logs/error.log в modx)*

Для частичной отладки без переустановки можно использовать левое меню, далее "элементы",
далее "плагины". Запись в лог делается функцией $modx->log(1, 'Сообщение'),
лог лежит в директории core/cache/logs/