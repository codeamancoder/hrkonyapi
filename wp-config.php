<?php
/**
 * The base configurations of the WordPre*//*refix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL ayarları - Bu bilgileri sunucunuzdan alabilirsiniz ** //
/** WordPress için kullanılacak veritabanının adı */

//define('WP_CACHE', false); //Added by WP-Cache Manager
//define( 'WPCACHEHOME', '/home/admin/web/herkonyapi.com/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager

define('DISALLOW_FILE_EDIT', true);

define('DB_NAME', 'herkony_hrknyap');

/** MySQL veritabanı kullanıcısı */
define('DB_USER', 'herkony_hrknyap');

/** MySQL veritabanı parolası */
define('DB_PASSWORD', 'inSdArbG');

/** MySQL sunucusu */
define('DB_HOST', 'localhost');

/** Yaratılacak tablolar için veritabanı karakter seti. */
define('DB_CHARSET', 'utf8');

/** Veritabanı karşılaştırma tipi. Herhangi bir şüpheniz varsa bu değeri değiştirmeyin. */
define('DB_COLLATE', '');

/**#@+
 * Eşsiz doğrulama anahtarları.
 *
 * Her anahtar farklı bir karakter kümesi olmalı!
 * {@link http://api.wordpress.org/secret-key/1.1/salt WordPress.org secret-key service} servisini kullanarak yaratabilirsiniz.
 * Çerezleri geçersiz kılmak için istediğiniz zaman bu değerleri değiştirebilirsiniz. Bu tüm kullanıcıların tekrar giriş yapmasını gerektirecektir.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'HM2c%+%+tUoIls8HDj-jw[$o%^b9`fE{Faz0{.GtJ0iGRbpy2;_h0~-?-fk|$OPqGd+x');
define('SECURE_AUTH_KEY',  'Lm|kw=A)A}%+%&<TMSCW[eKL2L|T8i<L=hBVNuTKrVWOvqy#XUX0wqm@9aW(B|7!Vv<0');
define('LOGGED_IN_KEY',    'Wfn?L=8 ikspd%%&%&m$KbxL.InYt$_.E9AJg`{|+V(ubF%/+B0MQ)9F;3T7y6Z4=3==');
define('NONCE_KEY',        'IPN]|MpK)BX<-0wazN5656yJchZ0LLzsm6sVPyUqIXy1[z-zc>k#[}J4 ~Fj0rQv``>/');
define('AUTH_SALT',        'T1_B(a$hAQ5QPyaPM1}+>?5656|-6X0Fg$Ut&.i>cY&lmAr)^xa<d]&lg5MN7uBMttF3');
define('SECURE_AUTH_SALT', 'z1[RD4l>G@%7~v[+Z]|;[915656!2^lYg(f`pKpNBL-Z`}v3o!txE$+Wa5YtNcG=[3+1');
define('LOGGED_IN_SALT',   'N69Z-YiB1.9kB=<dBZR)xto0l5656U[SNWM::K#]Pr`jW}~&dy]j|IA|5PFZ4pTC>jIg');
define('NONCE_SALT',       '~j$fDn-;_hE Y%/m%fZ=$,f~Q[i<5656dy<VcyJ*ouk_ic)U^BO4-^r:1.,k]?LQcd[o');
/**#@-*/

/**
 * Wor*//*n fazla kurulum yapabilirsiniz.
 * Sadece rakamlar, harfler ve alt çizgi lütfen.
 */
$table_prefix  = 'cmrfu_';

/**
 * WordPress yerel dil dosyası, varsayılan ingilizce.
 *
 * Bu değeri değiştirmenize gerek yok! Zaten Türkçe'ye ayarlı.
 * tr_TR.mo Türkçe dil dosyasının wp-content/languages dizini altında olduğundan emin olun.
 * Türkçe çeviri hakkında öneri ve eleştirilerinizi iletisim@wordpress-tr.com adresine iletebilirsiniz.
 *
 */
define('WPLANG', 'tr_TR');

/**
 * For de*//*ces during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* Hepsi bu kadar. Mutlu bloglamalar! */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
