<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// team
class Uta_Team extends Widget_Base {

    public function get_name() {
        return 'uta-team';
    }

    public function get_title() {
        return esc_html__( 'UTA Team', 'unlimited-theme-addons' );
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_keywords() {
        return [
            'team',
            'uta team',
            'uta',
            'team widget',
            'widget',
            'addons',
            'team addons',
            'unlimited theme addons',
        ];
    }

    public function get_categories() {
        return [ 'uta-elements' ];
    }
    protected function _register_controls() {
        $this->start_controls_section(
            'team_section',
            [
                'label' => esc_html__( 'team', 'unlimited-theme-addons' ),
                'type'  => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'image',
            [
                'label'   => __( 'Choose photo', 'unlimited-theme-addons' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'name',
            [
                'label'   => __( 'Name', 'unlimited-theme-addons' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'John Doe', 'unlimited-theme-addons' ),
            ]
        );
        $this->add_control(
            'designation',
            [
                'label'   => __( 'Designation', 'unlimited-theme-addons' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'App Developer', 'unlimited-theme-addons' ),
            ]
        );

        $social = new \Elementor\Repeater();

        $social->add_control(
            'social_icon', [
                'label'   => __( 'Social Icon', 'unlimited-theme-addons' ),
                'type'    => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fab fa-facebook-f',
                    'library' => 'solid',
                ],
            ]
        );

        $social->add_control(
            'social_url', [
                'label'   => __( 'Socia URL', 'unlimited-theme-addons' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '#',
            ]
        );

        $this->add_control(
            'social_media',
            [
                'label'       => __( 'social profile', 'unlimited-theme-addons' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $social->get_controls(),
                'title_field' => 'Social Item',
                'default'     => [
                    [
                        'social_icon' => [
                            'value'   => 'fab fa-facebook-f',
                            'library' => 'fa-brands',
                        ],
                        'social_url'  => '#',
                    ],
                    [
                        'social_icon' => [
                            'value'   => 'fab fa-linkedin-in',
                            'library' => 'fa-brands',
                        ],
                        'social_url'  => '#',
                    ],
                    [
                        'social_icon' => [
                            'value'   => 'fab fa-twitter',
                            'library' => 'fa-brands',
                        ],
                        'social_url'  => '#',
                    ],

                ],
                'title_field' => '{{{ social_icon.value }}}',
            ]
        );

        $this->end_controls_section();
    }
    protected function render( $instance = [] ) {

        // get our input from the widget settings.

        $settings = $this->get_settings_for_display();

        //Inline Editing
        $this->add_inline_editing_attributes( 'name', 'basic' );
        $this->add_inline_editing_attributes( 'designation', 'basic' );
        ?>

        <div class="uta-team">
            <?php echo wp_get_attachment_image( $settings['image']['id'], 'uta-400x400' ); ?>
            <h4 <?php echo esc_html(  $this->get_render_attribute_string( 'name' ) ); ?>><?php echo esc_html( $settings['name'] ); ?></h4>
            <span <?php echo esc_html( $this->get_render_attribute_string( 'designation' ) ); ?>><?php echo esc_html( $settings['designation'] ); ?></span>
            <ul class="list-inline">
                <?php
                foreach ( $settings['social_media'] as $single_social ) { ?>
                    <li class="list-inline-item">
                        <a href="<?php echo esc_attr( $single_social['social_url'] ) ?>">
                            <?php \Elementor\Icons_Manager::render_icon( $single_social['social_icon'], [ 'aria-hidden' => 'true' ] );?>
                        </a>
                    </li>
                    <?php
                } ?>
            </ul>
        </div>
        <?php
    }

}
Plugin::instance()->widgets_manager->register_widget_type( new Uta_Team() );