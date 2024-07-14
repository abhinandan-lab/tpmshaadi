<?php
class Elementor_HW1 extends \Elementor\Widget_Base {

    public function get_name() {
        return 'hw1';
    }

    public function get_title() {
        return esc_html__( 'Hello World 1', 'elementor-addon' );
    }

    public function get_icon() {
        return 'eicon-code';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    public function get_keywords() {
        return [ 'hello', 'world' ];
    }

    protected function register_controls() {

        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Audio', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'audio_source',
            [
                'label' => esc_html__( 'Audio Source', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'self_hosted' => [
                        'title' => esc_html__( 'Self Hosted', 'elementor-addon' ),
                        'icon' => 'fa fa-file',
                    ],
                    'link' => [
                        'title' => esc_html__( 'Link', 'elementor-addon' ),
                        'icon' => 'fa fa-link',
                    ],
                ],
                'default' => 'link',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'self_hosted_audio',
            [
                'label' => esc_html__( 'Choose audio file', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src()],
                'media_type' => 'audio',
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'audio_source' => 'self_hosted',
                ],
            ]
        );

        $this->add_control(
            'audio_link',
            [
                'label' => esc_html__( 'Enter audio URL', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'audio_source' => 'link',
                ],
            ]
        );

        $this->end_controls_section();

        // Content Tab End
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $audio_source = $settings['audio_source'];

        echo '<pre>';
        print_r($audio_source);
        echo '</pre>';

        if ($audio_source === 'self_hosted') {
            $audio_url = $settings['self_hosted_audio']['url'];
            if (!empty($audio_url)) {
                echo '<audio controls><source src="' . $audio_url . '" type="audio/mpeg">Your browser does not support the audio element.</audio>';
            }
        } elseif ($audio_source === 'link') {
            $audio_link = $settings['audio_link']['url'];
            if (!empty($audio_link)) {
                echo '<audio controls><source src="' . $audio_link . '" type="audio/mpeg">Your browser does not support the audio element.</audio>';
            }
        }
    }


}
