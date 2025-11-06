<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'WeFixProServiceGlogalSettings' ) ) {

    class WeFixProServiceGlogalSettings{

        private static $_instance = null;

		public static function instance()
		{
			if (is_null(self::$_instance)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

        /**
         * Constructor - hook into WordPress
         */
        public function __construct() {

            add_action( 'wp_ajax_save_service_settings', array( $this, 'save_service_settings' ) );
            add_action( 'wp_ajax_nopriv_save_service_settings', array( $this, 'save_service_settings' ) );

        }

        /**
         * Save settings handler
         */
        public function save_service_settings() {

            if (!current_user_can('manage_options')) {
                wp_send_json_error('Permission denied');
            }

            if (!check_ajax_referer('wefix_ajax_settings_nonce', 'security', false)) {
                wp_send_json_error('Nonce verification failed');
            }

            $settings = $_POST['_wefix_service_settings'] ?? [];

            $currency_key = sanitize_text_field($settings['currency'] ?? '');
            $custom       = sanitize_text_field($settings['custom_symbol'] ?? '');

            // Get actual symbol from internal list
            $symbols = $this->get_currency_symbols();

            $final_symbol = ($currency_key === 'custom')
                ? $custom
                : html_entity_decode($symbols[$currency_key] ?? '');

            $sanitized = [
                'layout'          => sanitize_text_field($settings['layout'] ?? '3'),
                'count'           => absint($settings['count'] ?? 6),
                'currency'        => $currency_key,
                'custom_symbol'   => ($currency_key === 'custom') ? $custom : '',
                'currency_symbol' => $final_symbol
            ];

            update_option('_wefix_service_settings', $sanitized);

            wp_send_json_success('Settings saved successfully.');
        }


        /**
         * Render the settings page HTML
         */
        public function render_settings_page() {

            $settings = get_option('_wefix_service_settings', []);
            $settings = wp_parse_args($settings, [
                'layout'          => '3',
                'count'           => 5,
                'currency'        => 'dollar',
                'currency_symbol' => '$'
            ]);

            $symbols = $this->get_currency_symbols();

            $this->render_settings_form($settings, $symbols);
        }

	    private function render_settings_form($settings, $symbols) {
            ?>
            <div class="wrap">
                <h1>Global Service Settings</h1>
                <form id="wefix-settings-form" method="post">
                    <?php wp_nonce_field('wefix_ajax_settings_nonce', 'security'); ?>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="service_count"><strong>Number of Services to Display</strong></label>
                            </th>
                            <td>
                                <input type="number" name="_wefix_service_settings[count]" id="service_count" min="1" max="100" value="<?php echo esc_attr($settings['count']); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="service_layout"><strong>Service Layout Columns</strong></label>
                            </th>
                            <td>
                                <select name="_wefix_service_settings[layout]" id="service_layout">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php selected($settings['layout'], (string)$i); ?>><?php echo $i; ?> Columns</option>
                                    <?php endfor; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="currency_symbol"><strong>Currency Symbol</strong></label>
                            </th>
                            <td>
                                <select name="_wefix_service_settings[currency]" id="currency_symbol">
                                    <?php foreach ($symbols as $key => $symbol): ?>
                                        <option value="<?php echo esc_attr($key); ?>" <?php selected($settings['currency'], $key); ?>>
                                            <?php echo html_entity_decode($symbol) . ' - ' . esc_html(ucwords(str_replace('_', ' ', $key))); ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <option value="custom" <?php selected($settings['currency'], 'custom'); ?>>Custom</option>
                                </select>

                                <div id="custom_currency_wrap" style="margin-top: 10px; display: <?php echo ($settings['currency'] === 'custom') ? 'block' : 'none'; ?>">
                                    <input type="text" name="_wefix_service_settings[custom_symbol]" id="custom_currency_symbol"
                                        value="<?php echo esc_attr($settings['custom_symbol'] ?? ''); ?>"
                                        placeholder="Enter custom symbol" />
                                </div>
                            </td>
                        </tr>
                    </table>

                    <?php submit_button('Save Settings'); ?>
                </form>
            </div>
            <?php
        }

	    private function get_currency_symbols() {
            return [
                'dollar'        => '&#36;',
                'euro'          => '&#128;',
                'baht'          => '&#3647;',
                'franc'         => '&#8355;',
                'guilder'       => '&fnof;',
                'krona'         => 'kr',
                'lira'          => '&#8356;',
                'peseta'        => '&#8359;',
                'peso'          => '&#8369;',
                'pound'         => '&#163;',
                'real'          => 'R$',
                'ruble'         => '&#8381;',
                'rupee'         => '&#8360;',
                'indian_rupee'  => '&#8377;',
                'shekel'        => '&#8362;',
                'yen'           => '&#165;',
                'won'           => '&#8361;',
            ];
        }

    }

}

WeFixProServiceGlogalSettings::instance();