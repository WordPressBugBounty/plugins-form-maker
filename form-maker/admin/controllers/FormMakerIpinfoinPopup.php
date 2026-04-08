<?php

/**
 * Class FMControllerFormmakeripinfoinpopup
 */
class FMControllerFormmakeripinfoinpopup extends FMAdminController {
  /**
   * @var view
   */
  private $view;

  /**
   * Execute.
   */
  public function execute() {
    $this->display();
  }

  /**
   * Display.
   */
  public function display() {
    // Load FMViewFromipinfoinpopup class.
    require_once WDFMInstance(self::PLUGIN)->plugin_dir . "/admin/views/FMIpinfoinPopup.php";
    $this->view = new FMViewFromipinfoinpopup();
    // Get IP
    $ip = trim( (string) WDW_FM_Library(self::PLUGIN)->get('data_ip', '') );
    // Connect to IP api service and get IP info.
    // Use JSON to avoid unsafe unserialize of remote data.
    $ipinfo = array();
    if ( !empty($ip) ) {
      $response = wp_remote_get(
        'https://ip-api.com/json/' . rawurlencode($ip),
        array( 'timeout' => 5 )
      );
      if ( !is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200 ) {
        $decoded = json_decode(wp_remote_retrieve_body($response), true);
        if ( is_array($decoded) ) {
          $ipinfo = $decoded;
        }
      }
    }
    $city = '-';
    $country = '-';
    $countryCode = '-';
    $country_flag = '-';
    $timezone = '-';
    $lat = '-';
    $lon = '-';
    if ( !empty($ipinfo) && isset($ipinfo['status']) && $ipinfo['status'] == 'success' && !empty($ipinfo['countryCode']) ) {
      $city = $ipinfo['city'];
      $country = $ipinfo['country'];
      $countryCode = $ipinfo['countryCode'];
      $flag_src = WDFMInstance(self::PLUGIN)->plugin_url . '/images/flags/' . strtolower($ipinfo['countryCode']) . '.png';
      $country_flag = '<img width="16px" src="' . esc_url($flag_src) . '" class="sub-align" alt="' . esc_attr($ipinfo['country']) . '" title="' . esc_attr($ipinfo['country']) . '" />';
      $timezone = $ipinfo['timezone'];
      $lat = $ipinfo['lat'];
      $lon = $ipinfo['lon'];
    }
    // Set params for view.
    $params = array();
    $params['ip'] = $ip;
    $params['city'] = $city;
    $params['country'] = $country;
    $params['country_flag'] = $country_flag;
    $params['countryCode'] = $countryCode;
    $params['timezone'] = $timezone;
    $params['lat'] = $lat;
    $params['lon'] = $lon;
    $this->view->display($params);
  }
}
