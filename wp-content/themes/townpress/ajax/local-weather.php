<?php

/* -----------------------------------------------------------------------------

    Get Weather Data from Open Weather Api
    http://openweathermap.org

----------------------------------------------------------------------------- */

$api_key = lsvr_get_field( 'locale_weather_api_key', '' );
$location_query = lsvr_get_field( 'locale_weather_location', '' );
$location_latitude = lsvr_get_field( 'locale_weather_latitude', '' );
$location_longitude = lsvr_get_field( 'locale_weather_longitude', '' );
$units_format = lsvr_get_field( 'locale_weather_units_format', 'metric' );

$cache_file_current = get_template_directory() . '/ajax/localweather.current.cache.json';
$cache_file_forecast = get_template_directory() . '/ajax/localweather.forecast.cache.json';
$cache_interval = ( (int) lsvr_get_field( 'locale_weather_cache_interval', 30 ) ) * 60;

$weather_type = isset( $_POST ) && is_array( $_POST ) && array_key_exists( 'weather_type', $_POST ) ? $_POST['weather_type'] : 'current';

// PREPARE URL POSTFIX
$request_url_postfix = $location_latitude !== '' && $location_longitude !== '' ? 'lat=' . $location_latitude . '&lon=' . $location_longitude : 'q=' . urlencode( $location_query );
$request_url_postfix .= '&units=' . $units_format . '&APPID=' . $api_key;

// PREPARE FOR FORECAST
if ( $weather_type === 'forecast' ) {
	$request_url = 'http://api.openweathermap.org/data/2.5/forecast/daily?' . $request_url_postfix ;
	$cache_file = $cache_file_forecast;
}

// PREPARE FOR CURRENT
else {
	$request_url = 'http://api.openweathermap.org/data/2.5/weather?' . $request_url_postfix ;
	$cache_file = $cache_file_current;
}

// GET JSON FROM CACHE
if ( $cache_interval > 0 && file_exists( $cache_file ) && ( ( time() - filemtime( $cache_file ) ) < $cache_interval ) ) {
	$json = file_get_contents( $cache_file );
}

// GET JSON FROM REQUEST
else {

	$json = @wp_remote_request( $request_url );

	if ( is_array( $json ) && array_key_exists( 'body', $json ) ) {
		$json = $json['body'];
	}

	// WRITE CACHE
	if ( isset( $json ) && is_string( $json ) && ( substr( $json, 0, 1 ) === '{' ) && ( $cache_interval > 0 ) ) {
		$fp = fopen( $cache_file, 'wb' );
		fwrite( $fp, $json );
		fclose( $fp );
	}
	else if ( file_exists( $cache_file ) && $cache_interval === 0 ) {
		unlink( $cache_file );
	}

}

// RETURN
if ( isset( $json ) && is_string( $json ) && ( $json[0] === '{' || $json[0] === '[' ) ) {
	echo $json;
}
else {
	echo 'error';
}

?>