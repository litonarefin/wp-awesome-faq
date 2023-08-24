<?php 

if ( !class_exists('JT_Colorful_FAQ_Settings_API' ) ){

    class JT_Colorful_FAQ_Settings_API {

        private $settings_api;

        function __construct() {

            $this->settings_api = new JT_Colorful_FAQ_Settings_API_Class;

            add_action( 'admin_init', array($this, 'jltmaf_admin_init') );
            add_action( 'admin_menu', array($this, 'jltmaf_admin_menu') );
            add_action( 'admin_enqueue_scripts', array( $this, 'jltmaf_admin_enqueue_scripts' ) );
        }

        function jltmaf_admin_enqueue_scripts(){
            wp_enqueue_style('dashicons');
            wp_enqueue_style( 'master-accordion-admin', JLTWPAFAQ_URL . '/assets/css/maf-admin.css' );
        }

        function jltmaf_admin_init() {

            //set the settings
            $this->settings_api->set_sections( $this->get_settings_sections() );
            $this->settings_api->set_fields( $this->get_settings_fields() );
            //initialize settings
            $this->settings_api->admin_init();
        }

        function jltmaf_admin_menu() {
            add_submenu_page('edit.php?post_type=faq', 
                __('FAQ Admin Settings', 'wp-awesome-faq' ),
                __('Settings', 'wp-awesome-faq' ),
                'edit_posts', 
                'jltmaf_faq_settings', 
                array($this, 'plugin_page') 
            );
        }

        function get_settings_sections() {
            $sections = array(
                array(
                    'id' => 'jltmaf_content',
                    'title' => __( 'Content', 'wp-awesome-faq' )
                ),
                array(
                    'id' => 'jltmaf_settings',
                    'title' => __( 'Settings', 'wp-awesome-faq' )
                ),
                array(
                    'id' => 'jltmaf_free_vs_pro',
                    'title' => __( 'Free vs Pro', 'wp-awesome-faq' ),
                    'callback' => [$this, 'html_only']
                )
            );
            return $sections;
        }

        function html_only(){
            return 'html';
        }
        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         */
        function get_settings_fields() {
            
            /* Master FAQ General Settings */
            $settings_fields = array(

                'jltmaf_content' => array(
                    array(
                        'name' => 'posts_per_page',
                        'label' => __( 'FAQ Posts Per Page', 'wp-awesome-faq' ),
                        'desc' => __( 'Choose FAQ Posts per page (-1 for All Posts).', 'wp-awesome-faq' ),
                        'type' => 'text',
                        'default' => '-1'
                    ),
                    array(
                        'name' => 'faq-title-bg-color',
                        'label' => __( 'Title Background Color', 'wp-awesome-faq' ),
                        'desc' => __( 'Select FAQ Default Background Color. Default: #2c3e50', 'wp-awesome-faq' ),
                        'default' => '#2c3e50',
                        'type' => 'color'
                    ),  

                    array(
                        'name' => 'faq-title-text-color',
                        'label' => __( 'Title Text Color', 'wp-awesome-faq' ),
                        'desc' => __( 'Select FAQ Default Title Text Color. Default: #ffffff', 'wp-awesome-faq' ),
                        'default' => '#ffffff',
                        'type' => 'color'
                    ),

                    array(
                        'name' => 'faq-bg-color',
                        'label' => __( 'Content Background Color', 'wp-awesome-faq' ),
                        'desc' => __( 'Select FAQ Default Content Background Color. Default: #ffffff', 'wp-awesome-faq' ),
                        'default' => '#ffffff',
                        'type' => 'color'
                    ),                               

                    array(
                        'name' => 'faq-text-color',
                        'label' => __( 'Content Text Color', 'wp-awesome-faq' ),
                        'desc' => __( 'Select FAQ Content Default Text Color. Default: #444', 'wp-awesome-faq' ),
                        'default' => '#444',
                        'type' => 'color'
                    )
                ),

                'jltmaf_settings' => array(
                    array(
                        'name' => 'faq_close_icon',
                        'label' => __( 'Collapse Icon', 'wp-awesome-faq' ),
                        'desc' => __( 'Choose FAQ\'s Close icon', 'wp-awesome-faq' ),
                        'type' => 'fonticon',
                        'default' => 'fa fa-chevron-up',
                        'options' => jltmaf_fa_icons()            
                    ),

                    array(
                        'name' => 'faq_open_icon',
                        'label' => __( 'Open Icon', 'wp-awesome-faq' ),
                        'desc' => __( 'Choose FAQ\'s Open icon', 'wp-awesome-faq' ),
                        'type' => 'fonticon',
                        'default' => 'fa fa-chevron-down',
                        'options' => jltmaf_fa_icons()            
                    ),

                    array(
                        'name'    => 'faq_icon_position',
                        'label'   => __( 'Icon Alignment', 'wp-awesome-faq' ),
                        'desc'    => __( 'Alignment Icon position for FAQ Title', 'wp-awesome-faq' ),
                        'type'    => 'select',
                        'default' => 'none',
                        'options' => array(
                            'none'            => __('Default', 'wp-awesome-faq'),
                            'left'            => __('Left', 'wp-awesome-faq'),
                            'right'           => __('Right', 'wp-awesome-faq')
                        )
                    ),

                    array(
                        'name'    => 'faq_collapse_style',
                        'label'   => __( 'Open/Collapse Style', 'wp-awesome-faq' ),
                        'desc'    => __( 'Select your FAQ\'s Open/Collapse Style ', 'wp-awesome-faq' ),
                        'type'    => 'select',
                        'default' => 'close_all',
                        'options' => array(
                            'close_all'         => __('Close All', 'wp-awesome-faq'),
                            'open_all'          => __('Open All', 'wp-awesome-faq'),
                            'first_open'        => __('1st Item Open', 'wp-awesome-faq')
                        )
                    ),
                    array(
                        'name'    => 'faq_heading_tags',
                        'label'   => __( 'Heading Tag', 'wp-awesome-faq' ),
                        'desc'    => __( 'Select your Heading Title Tags', 'wp-awesome-faq' ),
                        'type'    => 'select',
                        'default' => 'h3',
                        'options' => array(
                            'h1'         => __('H1', 'wp-awesome-faq'),
                            'h2'         => __('H2', 'wp-awesome-faq'),
                            'h3'         => __('H3', 'wp-awesome-faq'),
                            'h4'         => __('H4', 'wp-awesome-faq'),
                            'h5'         => __('H5', 'wp-awesome-faq'),
                            'h6'         => __('H6', 'wp-awesome-faq'),
                            'span'       => __('span', 'wp-awesome-faq'),
                            'p'          => __('p', 'wp-awesome-faq'),
                            'div'        => __('div', 'wp-awesome-faq'),
                        )
                    ),
                ), 
                'jltmaf_free_vs_pro' => array(
                    array(
                        'name'          => '',
                        'type'          => 'html_content',
                        'reference'     => $this->jltmaf_free_vs_pro()
                    ),
                )

            );

            return $settings_fields;
        }


        function jltmaf_free_vs_pro(){
            ob_start(); ?>

                   <thead>
                      <tr>
                         <td>
                            <strong>
                               <h3><?php esc_html_e( 'Feature', 'wp-awesome-faq' ); ?></h3>
                            </strong>
                         </td>
                         <td style="width:20%;">
                            <strong>
                               <h3><?php esc_html_e( 'Free', 'wp-awesome-faq' ); ?></h3>
                            </strong>
                         </td>
                         <td style="width:20%;">
                            <strong>
                               <h3><?php esc_html_e( 'Pro', 'wp-awesome-faq' ); ?></h3>
                            </strong>
                         </td>
                      </tr>
                   </thead>

                   <tbody>
                      <tr>
                         <td><?php esc_html_e( 'Elementor support', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Classic Editor Support', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Gutenberg Support', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Shortcode Generator - Classic Editor', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Gutenberg Block ( Master FAQ Accordion)', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Custom Elementor blocks(Master Accordion Addon)', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Nested FAQ', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Drag & Drop Sorting FAQ Items', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Translation ready', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Heading Tags Selection', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'FAQ by Category', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'FAQ by Tags', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Accordion/Toogle Type', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Single FAQ Template', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Open/Close Icon Settings', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Individual Open/Close Icon Settings', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Icon Alignment(Left/Right) Settings', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Collapse/Open Style(1st Open, Close All, Open All) Settings', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Title Heading Selection Settings', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Title Color Settings', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Individual Title Color Settings', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Title Background Settings', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Individual Title Background Settings', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Content Background Settings', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Individual Content Background Settings', 'wp-awesome-faq' ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                   </tbody>

                   <p style="text-align: right;">
                      <a class="button button-primary button-large" href="https://jeweltheme.com/shop/wordpress-faq-plugin/?utm_source=plugin_admin&utm_medium=button&utm_campaign=dashboard" target="_blank"><?php esc_html_e('View Master Accordion Pro', 'wp-awesome-faq'); ?>
                      </a>
                   </p>



        <?php 
            $output = ob_get_contents();
          ob_end_clean();
          
          return $output;
        }

       function plugin_page() {
            $user = wp_get_current_user();
            ?>

                
            <div class="info-container">

                <p class="hello-user">
                    <?php echo sprintf( __( 'Hello, %s,', 'wp-awesome-faq' ), '<span>' . esc_html( ucfirst( $user->display_name ) ) . '</span>' ); ?>
                </p>
                <h1 class="info-title">
                    <?php echo sprintf( __( 'Welcome to %s', 'wp-awesome-faq' ), JLTWPAFAQ ); ?>
                    <span class="info-version">
                        <?php echo 'v' . JLTWPAFAQ_VER; ?>    
                    </span>
                </h1>
                <p class="welcome-desc">
                    <?php _e( 'Master Accordion is now installed and ready to go. To help you with the next step, we’ve gathered together on this page all the resources you might need. We hope you enjoy using Master Accordion. You can always come back to this page by going to <strong>FAQs > Settings</strong>.', 'wp-awesome-faq' ); ?>

                    [faq items="-1" cat="Category Name" tag="Tag name" orderby"title" order="ASC"]

                    
                </p>


                <div class="jltmaf-theme-tabs">
                    <?php 
                        $this->settings_api->show_navigation();
                        $this->settings_api->show_forms();
                    ?>

                    <div id="jltmaf_support" class="jltmaf-tab support">
                        <div class="column-wrapper">
                            <div class="tab-column">
                            <span class="dashicons dashicons-sos"></span>
                            <h3><?php esc_html_e( 'Visit our forums', 'wp-awesome-faq' ); ?></h3>
                            <p><?php esc_html_e( 'Need help? Go ahead and visit our support forums and we\'ll be happy to assist you with any theme related questions you might have', 'wp-awesome-faq' ); ?></p>
                                <a href="https://jeweltheme.com/support/forum/wordpress-plugins/wp-awesome-faq/" target="_blank"><?php esc_html_e( 'Visit the forums', 'wp-awesome-faq' ); ?></a>              
                                </div>
                            <div class="tab-column">
                            <span class="dashicons dashicons-book-alt"></span>
                            <h3><?php esc_html_e( 'Documentation', 'wp-awesome-faq' ); ?></h3>
                            <p><?php esc_html_e( 'Our documentation can help you learn how to use the theme and also provides you with premade code snippets and answers to FAQs.', 'wp-awesome-faq' ); ?></p>
                            <a href="https://docs.jeweltheme.com/category/wordpress-plugins/awesome-faq-pro/" target="_blank"><?php esc_html_e( 'See the Documentation', 'wp-awesome-faq' ); ?></a>
                            </div>
                        </div>
                    </div>

                </div> <!-- jltmaf-theme-tabs -->


                <div class="jltmaf-theme-sidebar">
                    <div class="jltmaf-sidebar-widget">
                        <h3>Review Master Accordion</h3>
                        <p>It makes us happy to hear from our users. We would appreciate a review. </p> 
                        <p><a target="_blank" href="https://wordpress.org/support/plugin/wp-awesome-faq/reviews/#new-post">Write a review here</a></p>     
                    </div>
                    <hr style="margin-top:25px;margin-bottom:25px;">
                    <div class="jltmaf-sidebar-widget">
                        <h3>Changelog</h3>
                        <p>Keep informed about each theme update. </p>  
                        <p><a target="_blank" href="https://wordpress.org/plugins/wp-awesome-faq/#developers">See the changelog</a></p>       
                    </div>  
                    <hr style="margin-top:25px;margin-bottom:25px;">
                    <div class="jltmaf-sidebar-widget">
                        <h3>Upgrade to Master Accordion Pro</h3>
                        <p>Take your "Master Accordions" to a whole other level by upgrading to the Pro version. </p>   
                        <p><a target="_blank" href="https://jeweltheme.com/shop/wordpress-faq-plugin/?utm_source=plugin_admin&utm_medium=button&utm_campaign=dashboard">Discover Master Accordion Pro</a></p>      
                    </div>                                  
                </div>

            </div>

            <?php 

            // echo '</div>';
        }

        /**
         * Get all the pages
         *
         * @return array page names with key value pairs
         */
        function get_pages() {
            $pages = get_pages();
            $pages_options = array();
            if ( $pages ) {
                foreach ($pages as $page) {
                    $pages_options[$page->ID] = $page->post_title;
                }
            }

            return $pages_options;
        }

    }
}

$settings = new JT_Colorful_FAQ_Settings_API();
