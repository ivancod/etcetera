<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', "etcetera" );


/** Имя пользователя MySQL */
define( 'DB_USER', "root" );


/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', "" );


/** Имя сервера MySQL */
define( 'DB_HOST', "localhost" );


/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );


/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '!:|Ey>qghKy;F~h:@ O@@F>apuZYMh91PD*pC6J0dn<!rWSbn2GgQ=m5K>r|Z&Dw' );

define( 'SECURE_AUTH_KEY',  'bM.>kpg^&A?_MGP`-j3+@)?K_uJ|hWhI%A(r&fXkgOMHsAi_ycZ>><J|d8LnL$Zj' );

define( 'LOGGED_IN_KEY',    ')VL0-5I6XWokf:g)*w!GsfR=D7Y9o*_:m1qC~?hLq.#++i#&eS:Dzt):j[-5ec?B' );

define( 'NONCE_KEY',        'E?7G8vGG&htX(KP2ldINs 4%T MJ}}>L{yY?wo:90mg1SdV`~s[-aul>RWP3:tF}' );

define( 'AUTH_SALT',        '0WS;KxncX8K6%h=x?r?ST[~b`bY?E38QxfK3ZTS4Z*qnTnNJ/Vj_T<o!u?SF|)9b' );

define( 'SECURE_AUTH_SALT', '0H1_t/CYv.rD-v;h.|!I(AId-<tn|o8/5.4x8+Qau,r^.m&bvZP|(jl*zmC<)!S(' );

define( 'LOGGED_IN_SALT',   'Pt/3(L+Oo*YFU9BrE&-Y_GR02$=@*r+6/{Du:6`$)df[.:(Q2~/>V@Bk7OQCp1X]' );

define( 'NONCE_SALT',       ']zYUK6,7|JJ+kww_2qsM(|a+7Zr>2O:4ikY5,P]&;.0S}9ye<QUcL(:S|85tDjQU' );


/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';


/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
