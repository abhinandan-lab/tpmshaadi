



<?php
// Ensure this file is located in your Elementor custom plugin or theme

class Register1form extends \Elementor\Widget_Base {

    public function get_name() {
        return 'register1form';
    }

    public function get_title() {
        return __( 'Register from step1', 'elementor-custom-form-widget' );
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function render() {
        $nonce_field = wp_nonce_field('registers1_nonce', 'register1_action_nonce', true, false);

        ?>
        <form id="customForm" method="POST">
            <?php echo $nonce_field; ?>
            <input type="hidden" name="action" value="registers1">

            <div class="fieldgroup">
                <label for="email">Email</label>
                <input required name="email" type="email" placeholder="Enter your email">
            </div>

            <div class="fieldgroup">
                <span class="errors">d</span>
            </div>

            <div class="cont-flex">
                <button class="submit-btn" type="submit">Submit</button>
            </div>
        </form>
        <?php
    }

    protected function _content_template() {
        // Optional: Define a content template for live preview in Elementor editor
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Register1form() );
