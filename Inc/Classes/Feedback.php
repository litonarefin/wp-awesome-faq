<?php
namespace JLTWPAFAQ\Inc\Classes;

use JLTWPAFAQ\Inc\Classes\Notifications\Base\User_Data;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Feedback
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
class Feedback {

    use User_Data;

	/**
	 * Construct Method
	 *
	 * @return void
	 * @author Jewel Theme <support@jeweltheme.com>
	 */
    public function __construct(){
        add_action( 'admin_enqueue_scripts' , [ $this,'admin_suvery_scripts'] );
        add_action( 'admin_footer' , [ $this , 'deactivation_footer' ] );
        add_action( 'wp_ajax_jltwpafaq_deactivation_survey', array( $this, 'jltwpafaq_deactivation_survey' ) );

    }


    public function proceed(){

        global $current_screen;
        if(
            isset($current_screen->parent_file)
            && $current_screen->parent_file == 'plugins.php'
            && isset($current_screen->id)
            && $current_screen->id == 'plugins'
        ){
           return true;
        }
        return false;

    }

    public function admin_suvery_scripts($handle){
        if('plugins.php' === $handle){
            wp_enqueue_style( 'jltwpafaq-survey' , JLTWPAFAQ_ASSETS . 'css/plugin-survey.css' );
        }
    }

    /**
     * Deactivation Survey
     */
    public function jltwpafaq_deactivation_survey(){
        check_ajax_referer( 'jltwpafaq_deactivation_nonce' );

        $deactivation_reason  = ! empty( $_POST['deactivation_reason'] ) ? sanitize_text_field( wp_unslash( $_POST['deactivation_reason'] ) ) : '';

        if( empty( $deactivation_reason )){
            return;
        }

        $email = get_bloginfo( 'admin_email' );
        $author_obj = get_user_by( 'email', $email );
        $user_id    = $author_obj->ID;
        $full_name  = $author_obj->display_name;

        $response = $this->get_collect_data( $user_id, array(
            'first_name'              => $full_name,
            'email'                   => $email,
            'deactivation_reason'     => $deactivation_reason,
        ) );

        return $response;
    }


    public function get_survey_questions(){

        return [
			'no_longer_needed' => [
				'title' => esc_html__( 'I no longer need the plugin', 'wp-awesome-faq' ),
				'input_placeholder' => '',
			],
			'found_a_better_plugin' => [
				'title' => esc_html__( 'I found a better plugin', 'wp-awesome-faq' ),
				'input_placeholder' => esc_html__( 'Please share which plugin', 'wp-awesome-faq' ),
			],
			'couldnt_get_the_plugin_to_work' => [
				'title' => esc_html__( 'I couldn\'t get the plugin to work', 'wp-awesome-faq' ),
				'input_placeholder' => '',
			],
			'temporary_deactivation' => [
				'title' => esc_html__( 'It\'s a temporary deactivation', 'wp-awesome-faq' ),
				'input_placeholder' => '',
			],
			'jltwpafaq_pro' => [
				'title' => sprintf( esc_html__( 'I have %1$s Pro', 'wp-awesome-faq' ), JLTWPAFAQ ),
				'input_placeholder' => '',
				'alert' => sprintf( esc_html__( 'Wait! Don\'t deactivate %1$s. You have to activate both %1$s and %1$s Pro in order for the plugin to work.', 'wp-awesome-faq' ), JLTWPAFAQ ),
			],
			'need_better_design' => [
				'title' => esc_html__( 'I need better design and presets', 'wp-awesome-faq' ),
				'input_placeholder' => esc_html__( 'Let us know your thoughts', 'wp-awesome-faq' ),
			],
            'other' => [
				'title' => esc_html__( 'Other', 'wp-awesome-faq' ),
				'input_placeholder' => esc_html__( 'Please share the reason', 'wp-awesome-faq' ),
			],
		];
    }


        /**
         * Deactivation Footer
         */
        public function deactivation_footer(){

        if(!$this->proceed()){
            return;
        }

        ?>
        <div class="jltwpafaq-deactivate-survey-overlay" id="jltwpafaq-deactivate-survey-overlay"></div>
        <div class="jltwpafaq-deactivate-survey-modal" id="jltwpafaq-deactivate-survey-modal">
            <header>
                <div class="jltwpafaq-deactivate-survey-header">
                    <h3><?php echo wp_sprintf( '%1$s %2$s', JLTWPAFAQ, __( '- Feedback', 'wp-awesome-faq' ),  ); ?></h3>
                </div>
            </header>
            <div class="jltwpafaq-deactivate-info">
                <?php echo wp_sprintf( '%1$s %2$s', __( 'If you have a moment, please share why you are deactivating', 'wp-awesome-faq' ), JLTWPAFAQ ); ?>
            </div>
            <div class="jltwpafaq-deactivate-content-wrapper">
                <form action="#" class="jltwpafaq-deactivate-form-wrapper">
                    <?php foreach($this->get_survey_questions() as $reason_key => $reason){ ?>
                        <div class="jltwpafaq-deactivate-input-wrapper">
                            <input id="jltwpafaq-deactivate-feedback-<?php echo esc_attr($reason_key); ?>" class="jltwpafaq-deactivate-feedback-dialog-input" type="radio" name="reason_key" value="<?php echo $reason_key; ?>">
                            <label for="jltwpafaq-deactivate-feedback-<?php echo esc_attr($reason_key); ?>" class="jltwpafaq-deactivate-feedback-dialog-label"><?php echo esc_html( $reason['title'] ); ?></label>
							<?php if ( ! empty( $reason['input_placeholder'] ) ) : ?>
								<input class="jltwpafaq-deactivate-feedback-text" type="text" name="reason_<?php echo esc_attr( $reason_key ); ?>" placeholder="<?php echo esc_attr( $reason['input_placeholder'] ); ?>" />
							<?php endif; ?>
                        </div>
                    <?php } ?>
                    <div class="jltwpafaq-deactivate-footer">
                        <button id="jltwpafaq-dialog-lightbox-submit" class="jltwpafaq-dialog-lightbox-submit"><?php echo esc_html__( 'Submit &amp; Deactivate', 'wp-awesome-faq' ); ?></button>
                        <button id="jltwpafaq-dialog-lightbox-skip" class="jltwpafaq-dialog-lightbox-skip"><?php echo esc_html__( 'Skip & Deactivate', 'wp-awesome-faq' ); ?></button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            var deactivate_url = '#';

            jQuery(document).on('click', '#deactivate-wp-awesome-faq', function(e) {
                e.preventDefault();
                deactivate_url = e.target.href;
                jQuery('#jltwpafaq-deactivate-survey-overlay').addClass('jltwpafaq-deactivate-survey-is-visible');
                jQuery('#jltwpafaq-deactivate-survey-modal').addClass('jltwpafaq-deactivate-survey-is-visible');
            });

            jQuery('#jltwpafaq-dialog-lightbox-skip').on('click', function (e) {
                e.preventDefault();
                window.location.replace(deactivate_url);
            });


            jQuery(document).on('click', '#jltwpafaq-dialog-lightbox-submit', async function(e) {
                e.preventDefault();

                jQuery('#jltwpafaq-dialog-lightbox-submit').addClass('jltwpafaq-loading');

                var $dialogModal = jQuery('.jltwpafaq-deactivate-input-wrapper'),
                    radioSelector = '.jltwpafaq-deactivate-feedback-dialog-input';
                $dialogModal.find(radioSelector).on('change', function () {
                    $dialogModal.attr('data-feedback-selected', jQuery(this).val());
                });
                $dialogModal.find(radioSelector + ':checked').trigger('change');


                // Reasons for deactivation
                var deactivation_reason = '';
                var reasonData = jQuery('.jltwpafaq-deactivate-form-wrapper').serializeArray();

                jQuery.each(reasonData, function (reason_index, reason_value) {
                    if ('reason_key' == reason_value.name && reason_value.value != '') {
                        const reason_input_id = '#jltwpafaq-deactivate-feedback-' + reason_value.value,
                            reason_title = jQuery(reason_input_id).siblings('label').text(),
                            reason_placeholder_input = jQuery(reason_input_id).siblings('input').val(),
                            format_title_with_key = reason_value.value + ' - '  + reason_placeholder_input,
                            format_title = reason_title + ' - '  + reason_placeholder_input;

                        deactivation_reason = reason_value.value;

                        if ('found_a_better_plugin' == reason_value.value ) {
                            deactivation_reason = format_title_with_key;
                        }

                        if ('need_better_design' == reason_value.value ) {
                            deactivation_reason = format_title_with_key;
                        }

                        if ('other' == reason_value.value) {
                            deactivation_reason = format_title_with_key;
                        }
                    }
                });

                await jQuery.ajax({
                        url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
                        method: 'POST',
                        // crossDomain: true,
                        async: true,
                        // dataType: 'jsonp',
                        data: {
                            action: 'jltwpafaq_deactivation_survey',
                            _wpnonce: '<?php echo esc_js( wp_create_nonce( 'jltwpafaq_deactivation_nonce' ) ); ?>',
                            deactivation_reason: deactivation_reason
                        },
                        success:function(response){
                            window.location.replace(deactivate_url);
                        }
                });
                return true;
            });

            jQuery('#jltwpafaq-deactivate-survey-overlay').on('click', function () {
                jQuery('#jltwpafaq-deactivate-survey-overlay').removeClass('jltwpafaq-deactivate-survey-is-visible');
                jQuery('#jltwpafaq-deactivate-survey-modal').removeClass('jltwpafaq-deactivate-survey-is-visible');
            });
        </script>
        <?php
    }

}