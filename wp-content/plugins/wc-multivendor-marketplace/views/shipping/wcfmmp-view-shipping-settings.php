<?php 

  global $WCFM; 
  $user_id = apply_filters( 'wcfm_current_vendor_id', get_current_user_id() );
  $wcfmmp_shipping     = get_user_meta( $user_id, '_wcfmmp_shipping', true );
  $wcfmmp_all_shiping_types = wcfmmp_get_shipping_types();
  $wcfmmp_shipping_by_country = get_user_meta( $user_id, '_wcfmmp_shipping_by_country', true );
  //print_r($wcfmmp_shipping_by_country); die;
  $processing_time = wcfmmp_get_shipping_processing_times();

  $wcfmmp_country_rates       = get_user_meta( $user_id, '_wcfmmp_country_rates', true );
  $wcfmmp_state_rates         = get_user_meta( $user_id, '_wcfmmp_state_rates', true );
  $wcfmmp_marketplace_shipping_options = get_option( 'woocommerce_wcfmmp_product_shipping_by_country_settings', array() );
  
?>

  
<div id="wcfmmp_settings_form_shipping_expander" class="wcfm-content">
  <?php

    $WCFM->wcfm_fields->wcfm_generate_form_field (
              apply_filters( 'wcfmmp_settings_fields_shipping', array(
                "wcfmmp_shipping_enable" => array('label' => __('Enable Shipping', 'wc-multivendor-marketplace') , 'in_table' => true, 'name' => 'wcfmmp_shipping[_wcfmmp_user_shipping_enable]', 'type' => 'checkbox', 'class' => 'wcfm-checkbox wcfm_ele', 'label_class' => 'wcfm_title checkbox_title wcfm_ele', 'value' => 'yes', 'dfvalue' => isset($wcfmmp_shipping['_wcfmmp_user_shipping_enable'])? $wcfmmp_shipping['_wcfmmp_user_shipping_enable'] : 'no', 'hints' => __('Check this if you want to enable shipping for your store', 'wc-multivendor-marketplace') ),
                "wcfmmp_shipping_type" => array(
                    'label' => __('Shipping Type', 'wc-multivendor-marketplace') , 
                    'name' => 'wcfmmp_shipping[_wcfmmp_user_shipping_type]', 
                    'type' => 'select', 
                    'class' => 'wcfm-select wcfm_ele hide_if_shipping_disabled', 
                    'label_class' => 'wcfm_title select_title wcfm_ele hide_if_shipping_disabled', 
                    'options' => $wcfmmp_all_shiping_types, 
                    'value' => isset($wcfmmp_shipping['_wcfmmp_user_shipping_type'])? $wcfmmp_shipping['_wcfmmp_user_shipping_type'] : '', 
                    'hints' => __('Select shipping type for your store', 'wc-multivendor-marketplace') ) 
                ) )
            );
  ?>
</div>
  
<div id="wcfmmp_settings_form_shipping_by_country" class="wcfm-content shipping_type by_country hide_if_shipping_disabled">
  <div class="wcfm_vendor_settings_heading">
    <h3><?php _e('Shipping By Country', 'wc-multivendor-marketplace'); ?></h3>
  </div>
  <?php if(!isset($wcfmmp_marketplace_shipping_options['enabled']) || $wcfmmp_marketplace_shipping_options['enabled'] == 'no' ) {
    _e('Shipping By Country is disabled by Admin. Please contact admin for details', 'wc-multivendor-marketplace');
  } else { ?>
  <?php

    $WCFM->wcfm_fields->wcfm_generate_form_field (
        apply_filters( 'wcfmmp_settings_fields_shipping_by_country', array(
          "wcfmmp_shipping_type_price" => array('label' => __('Default Shipping Price', 'wc-multivendor-marketplace'), 'name' => 'wcfmmp_shipping_by_country[_wcfmmp_shipping_type_price]', 'placeholder' => '0.00', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'value' => isset($wcfmmp_shipping_by_country['_wcfmmp_shipping_type_price']) ? $wcfmmp_shipping_by_country['_wcfmmp_shipping_type_price'] : '', 'hints' => __('This is the base price and will be the starting shipping price for each product', 'wc-multivendor-marketplace') ),
          "wcfmmp_additional_product" => array('label' => __('Per Product Additional Price', 'wc-multivendor-marketplace'), 'name' => 'wcfmmp_shipping_by_country[_wcfmmp_additional_product]', 'placeholder' => '0.00', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'value' => isset($wcfmmp_shipping_by_country['_wcfmmp_additional_product']) ? $wcfmmp_shipping_by_country['_wcfmmp_additional_product'] : '', 'hints' => __('If a customer buys more than one type product from your store, first product of the every second type will be charged with this price', 'wc-multivendor-marketplace') ),
          "wcfmmp_additional_qty" => array('label' => __('Per Qty Additional Price', 'wc-multivendor-marketplace'), 'name' => 'wcfmmp_shipping_by_country[_wcfmmp_additional_qty]', 'placeholder' => '0.00', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'value' => isset($wcfmmp_shipping_by_country['_wcfmmp_additional_qty']) ? $wcfmmp_shipping_by_country['_wcfmmp_additional_qty'] : '', 'hints' => __('Every second product of same type will be charged with this price', 'wc-multivendor-marketplace') ),
          "wcfmmp_pt" => array('label' => __('Processing Time', 'wc-multivendor-marketplace'), 'name' => 'wcfmmp_shipping_by_country[_wcfmmp_pt]', 'type' => 'select', 'class' => 'wcfm-select wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'options' => $processing_time, 'value' => isset($wcfmmp_shipping_by_country['_wcfmmp_pt']) ? $wcfmmp_shipping_by_country['_wcfmmp_pt'] : '', 'hints' => __('The time required before sending the product for delivery', 'wc-multivendor-marketplace') ),            
          "wcfmmp_form_location" => array('label' => __('Ships from:', 'wc-multivendor-marketplace'), 'name' => 'wcfmmp_shipping_by_country[_wcfmmp_form_location]','type' => 'country', 'class' => 'wcfm-select wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'value' => isset($wcfmmp_shipping_by_country['_wcfmmp_form_location']) ? $wcfmmp_shipping_by_country['_wcfmmp_form_location'] : '', 'hints' => __( 'Location from where the products are shipped for delivery. Usually it is same as the store.', 'wc-multivendor-marketplace' ) ),
          ) )
      );

    $wcfmmp_shipping_rates = array();
    $state_options = array();
    if ( $wcfmmp_country_rates ) {
      foreach ( $wcfmmp_country_rates as $country => $country_rate ) {
        $wcfmmp_shipping_state_rates = array();
        $state_options = array();
        if ( !empty( $wcfmmp_state_rates ) && isset( $wcfmmp_state_rates[$country] ) ) {
          foreach ( $wcfmmp_state_rates[$country] as $state => $state_rate ) {
            $state_options[$state] = $state;
            $wcfmmp_shipping_state_rates[] = array( 
                'wcfmmp_state_to' => $state, 
                'wcfmmp_state_to_price' => $state_rate, 
                'option_values' => $state_options 
              );
          }
        }
        $wcfmmp_shipping_rates[] = array( 
            'wcfmmp_country_to' => $country, 
            'wcfmmp_country_to_price' => $country_rate, 
            'wcfmmp_shipping_state_rates' => $wcfmmp_shipping_state_rates 
          );
      }   
    }

    $WCFM->wcfm_fields->wcfm_generate_form_field( 
      apply_filters( 'wcfmmp_settings_fields_shipping_rates_by_country', array( 
        "wcfmmp_shipping_rates" => array(
            'label' => __('Shipping Rates by Country', 'wc-multivendor-marketplace') , 
            'type' => 'multiinput', 
            'label_class' => 'wcfm_title', 
            'value' => $wcfmmp_shipping_rates, 
            'desc' => __( 'Add the countries you deliver your products to. You can specify states as well. If the shipping price is same except some countries/states, there is an option Everywhere Else, you can use that.', 'wc-multivendor-marketplace' ), 
            'options' => array(
                "wcfmmp_country_to" => array(
                    'label' => __('Country', 'wc-multivendor-marketplace'), 
                    'type' => 'country',
                    'wcfmmp_shipping_country' => 1, 
                    'class' => 'wcfm-select wcfmmp_country_to_select', 
                    'label_class' => 'wcfm_title'
                ),
                "wcfmmp_country_to_price" => array( 
                    'label' => __('Cost', 'wc-multivendor-marketplace') . '('.get_woocommerce_currency_symbol().')', 
                    'type' => 'text', 
                    'class' => 'wcfm-text', 
                    'label_class' => 'wcfm_title' 
                ),
                "wcfmmp_shipping_state_rates" => array(
                    'label' => __('State Shipping Rates', 'wc-multivendor-marketplace'), 
                    'type' => 'multiinput', 
                    'label_class' => 'wcfm_title wcfmmp_shipping_state_rates_label', 
                    'options' => array(
                        "wcfmmp_state_to" => array( 
                            'label' => __('State', 'wc-multivendor-marketplace'), 
                            'type' => 'select', 'class' => 'wcfm-select wcfmmp_state_to_select', 
                            'label_class' => 'wcfm_title', 
                            'options' => $state_options 
                        ),
                        "wcfmmp_state_to_price" => array( 
                            'label' => __('Cost', 'wc-multivendor-marketplace') . '('.get_woocommerce_currency_symbol().')', 
                            'type' => 'text', 
                            'class' => 'wcfm-text', 
                            'label_class' => 'wcfm_title' 
                        ),

                    ) 
                )   
            ) 
        )
      ) ) 
    );
  }
  ?>
</div>

<?php
  $vendor_all_shipping_zones = wcfmmp_get_shipping_zone();

?>
<div id="wcfmmp_settings_form_shipping_by_zone" class="wcfm-content shipping_type by_zone hide_if_shipping_disabled">
  <table class="wcfmmp-table shipping-zone-table">
    <thead>
      <tr>
        <th><?php _e('Zone Name', 'wc-multivendor-marketplace'); ?></th> 
        <th><?php _e('Region(s)', 'wc-multivendor-marketplace'); ?></th> 
        <th><?php _e('Shipping Method', 'wc-multivendor-marketplace'); ?></th>
      </tr></thead> 
    <tbody>

          <?php 
          if(!empty($vendor_all_shipping_zones)) {

            foreach ($vendor_all_shipping_zones as $key => $vendor_shipping_zones ){ ?>
            <tr>
              <td>
                <a href="JavaScript:void(0);" data-zone-id="<?php echo $vendor_shipping_zones['zone_id']; ?>" class="vendor_edit_zone">
                  <?php _e( $vendor_shipping_zones['zone_name'], 'wc-multivendor-marketplace'); ?>
                </a> 
                <div class="row-actions">
                  <a href="JavaScript:void(0);" data-zone-id="<?php echo $vendor_shipping_zones['zone_id']; ?>" class="vendor_edit_zone">
                    <?php _e( 'Edit', 'wc-multivendor-marketplace' ); ?>
                  </a>
                </div>
              </td> 
              <td>
                <?php _e( $vendor_shipping_zones['formatted_zone_location'], 'wc-multivendor-marketplace'); ?>
              </td> 
              <td>
                <p>
                  <?php 
                    $vendor_shipping_methods = $vendor_shipping_zones['shipping_methods'];
                    $vendor_shipping_methods_titles = array_column($vendor_shipping_methods, 'title');
                    $vendor_shipping_methods_titles = implode(', ', $vendor_shipping_methods_titles);
                    //print_r($vendor_shipping_methods_titles);
                    if(empty($vendor_shipping_methods)) { ?>
                      <span><?php _e('No method found&nbsp;', 'wc-multivendor-marketplace'); ?> </span> 
                      <a href="JavaScript:void(0);" data-zone-id="<?php echo $vendor_shipping_zones['zone_id']; ?>" class="vendor_edit_zone"><?php _e(' Add Shipping Methods', 'wc-multivendor-marketplace'); ?></a>
                    <?php  
                    } else { ?>
                      <div><?php _e($vendor_shipping_methods_titles, 'wc-multivendor-marketplace'); ?> </div> 
                      <a href="JavaScript:void(0);" data-zone-id="<?php echo $vendor_shipping_zones['zone_id']; ?>" class="vendor_edit_zone"><?php _e(' Edit Shipping Methods', 'wc-multivendor-marketplace'); ?></a>
                    <?php }
                  ?> 

                </p>
              </td>
            </tr>
            <?php 
            }
          ?>

      <?php } else { ?>
        <tr>
          <td colspan="3">
            <?php _e('No shipping zone found for configuration. Please contact with admin for manage your store shipping', 'wc-multivendor-marketplace') ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <div id="vendor_edit_zone">
  </div>

</div>