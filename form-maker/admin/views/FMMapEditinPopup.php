<?php

/**
 * Class FMViewFrommapeditinpopup
 */
class FMViewFrommapeditinpopup extends FMAdminView {
  /**
   * Display.
   *
   * @param array $params
   */
  public function display( $params = array() ) {
    wp_print_scripts('google-maps');
    wp_print_scripts(WDFMInstance(self::PLUGIN)->handle_prefix . '-gmap_form');
    $long = isset( $params['long'] ) ? $params['long'] : '';
    $lat  = isset( $params['lat'] ) ? $params['lat'] : '';
    $long = WDW_FM_Library(self::PLUGIN)->sanitize_map_coordinate( $long, 'long' );
    $lat  = WDW_FM_Library(self::PLUGIN)->sanitize_map_coordinate( $lat, 'lat' );
    ?>
    <table style="margin:0px; padding:0px">
      <tr>
        <td><b><?php _e('Address:', WDFMInstance(self::PLUGIN)->prefix); ?></b></td>
        <td><input type="text" id="addrval0" style="border:0px; background:none" size="80" readonly /></td>
      </tr>
      <tr>
        <td><b><?php _e('Longitude:', WDFMInstance(self::PLUGIN)->prefix); ?></b></td>
        <td><input type="text" id="longval0" style="border:0px; background:none" size="80" readonly /></td>
      </tr>
      <tr>
        <td><b><?php _e('Latitude:', WDFMInstance(self::PLUGIN)->prefix); ?></b></td>
        <td><input type="text" id="latval0" style="border:0px; background:none" size="80" readonly /></td>
      </tr>
    </table>
    <div id="0_elementform_id_temp" long="<?php echo esc_attr( $long ); ?>" center_x="<?php echo esc_attr( $long ); ?>" center_y="<?php echo esc_attr( $lat ); ?>" lat="<?php echo esc_attr( $lat ); ?>" zoom="8" info="" style="width:600px; height:400px; "></div>
    <script>
      if_gmap_init("0");
      add_marker_on_map(0, 0, <?php echo WDW_FM_Library(self::PLUGIN)->js_string( $long ); ?>, <?php echo WDW_FM_Library(self::PLUGIN)->js_string( $lat ); ?>, "");
    </script>
    <?php

    die();
  }
}
