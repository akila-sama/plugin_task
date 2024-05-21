
<!-- akila_plugin.php code html separate here -->


<div class="wrap">
    <h2><?php _e('My Plugin Details', 'my-plugin-ajax'); ?></h2>
    <div class="plugin-info">
        <p><strong><?php _e('Plugin Name:', 'my-plugin-ajax'); ?></strong> <?php _e('My plugin ajax', 'my-plugin-ajax'); ?></p>
        <p><strong><?php _e('Description:', 'my-plugin-ajax'); ?></strong> <?php _e('This is a testing plugin. This plugin is my first plugin.', 'my-plugin-ajax'); ?></p>
        <p><strong><?php _e('Author:', 'my-plugin-ajax'); ?></strong><?php _e('akila', 'my-plugin-ajax'); ?></p>
        <p><strong><?php _e('Version:', 'my-plugin-ajax'); ?></strong><?php _e('1.0', 'my-plugin-ajax'); ?></p>
    </div>

    <h3><?php _e('Shortcode Details', 'my-plugin-ajax'); ?></h3>
    <div class="shortcode-info">
        <p><strong><?php _e('Shortcode Name:', 'my-plugin-ajax'); ?></strong> <?php _e('portfolio_submission_form')?></p>
        <p><strong><?php _e('Functionality:', 'my-plugin-ajax'); ?></strong> <?php _e('This shortcode allows users to submit their portfolio details through a form, including name, company name, email, phone, and address. Upon submission, the data is inserted into the custom post type \'portfolio\'.', 'my-plugin-ajax'); ?></p>
        <form>
            <input type="hidden" name="action" value="portfolio_submission">
            <?php wp_nonce_field('portfolio_submission_nonce', 'portfolio_submission_nonce_field'); ?>

            <label for="name"><?php _e('Name:', 'my-plugin-ajax'); ?></label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="company_name"><?php _e('Company Name:', 'my-plugin-ajax'); ?></label>
            <input type="text" id="company_name" name="company_name"><br><br>

            <label for="email"><?php _e('Email:', 'my-plugin-ajax'); ?></label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="phone"><?php _e('Phone:', 'my-plugin-ajax'); ?></label>
            <input type="tel" id="phone" name="phone"><br><br>

            <label for="address"><?php _e('Address:', 'my-plugin-ajax'); ?></label>
            <textarea id="address" name="address" rows="6"></textarea><br><br>
        </form>
    </div>
</div>
<div class="wrap">
    <h2><?php _e('Custom Page', 'my-plugin-ajax'); ?></h2>
    <form id="custom_data_form" method="post">
        <!-- Add nonce field to the form -->
        <?php wp_nonce_field('custom_data_nonce', 'custom_data_nonce'); ?>
        <label for="custom_data"><?php _e('Enter Custom Data:', 'my-plugin-ajax'); ?></label>
        <input type="text" id="custom_data" name="custom_data" value="<?php echo esc_attr(get_option('custom_data')); ?>" /><br>
        <input type="submit" id="submit_custom_data" name="submit_custom_data" class="button-primary" value="<?php _e('Save', 'my-plugin-ajax'); ?>" />
    </form>
    <div id="message"></div>
    <!-- This div will display the message -->
</div>