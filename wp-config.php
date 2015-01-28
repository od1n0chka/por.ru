<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи и ABSPATH. Дополнительную информацию можно найти на странице
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется скриптом для создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения вручную.
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'por.ru');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '`.9W/C<~Uefmwy$5**@-d.npAxZ~Z/7DknM#^BhX`l<5uE_fdKJ91iz|WdP-V|Pj');
define('SECURE_AUTH_KEY',  'QqOBKE+]qk8&b|,vf{ I]Gtd!24qX=,{w vF){Ryegv1@Dq3;1W9-+8{=J[O|pya');
define('LOGGED_IN_KEY',    '2M[Qr4y&Sfh_D_8ha+DY/<6eNe_eB[Gwl0F]e#WO|)fj0p[rZOR=[hV-]WEZ|+lK');
define('NONCE_KEY',        'k;<37i^mAb2w|I|k,/sauKGL5M#TD3)4z-1sW<C1--!8[o<F8`>D-8Mzz9|!.l8^');
define('AUTH_SALT',        '0>-05wF[Z<3|lm0W8>osQ7qBW*-}Q(+tB4M?}z^s=Gr4{6VZWl`9q$w[lGpz.S(X');
define('SECURE_AUTH_SALT', 'ce!8 RXU~E/{B7wi-I^7l9X* p8=|<goi?K;^^o>PR#?w5-F=:z-DrNjR(G_:pE0');
define('LOGGED_IN_SALT',   'ta/gqkxoa<*@pKsCK]uV~U+C<sszQnGUKP^|/yVn|L~/hJvH@Y{i2s]AZxn3rcu/');
define('NONCE_SALT',       '+8@,{|7&pFIhBy2)j~XjG`G!+f3V-702IezSqX%Q8k8tWUR&88O~mhpJ+1eKEzEa');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
