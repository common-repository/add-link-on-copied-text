<?php
/**
 * Class AddLinkOnCopiesText *
 * @version 1.0.0
 */
class AddLinkOnCopiesText{

    public static function init() {
        /* инициализируем меню в админке*/
        add_action( 'admin_menu', array( 'AddLinkOnCopiesText', 'add_admin_menu' ));

        add_action( 'admin_init', array( 'AddLinkOnCopiesText', 'plugin_settings' ));

    }

    public static function plugin_settings() {
        register_setting( 'option_group_aloct', 'aloct_option', 'sanitize_callback' );
        $trans1  = __( 'Plugin settings', 'add-link-on-copied-text' );
        $number_indents  = __( 'The number of indents after the copied text.', 'add-link-on-copied-text' );
        $text_before_link = __( 'Text before link', 'add-link-on-copied-text' );


        // параметры: $id, $title, $callback, $page
        add_settings_section( 'section_id', $trans1, '', 'section_aloct_1' );
        // параметры: $id, $title, $callback, $page, $section, $args

        add_settings_field( 'primer_field0', $text_before_link, array( 'AddLinkOnCopiesText', 'text_before_link' ), 'section_aloct_1', 'section_id' );
        add_settings_field( 'primer_field2', $number_indents, array( 'AddLinkOnCopiesText', 'number_indents' ), 'section_aloct_1', 'section_id' );
        add_settings_field( 'primer_field4', __('Link to home page only','add-link-on-copied-text'), array( 'AddLinkOnCopiesText', 'in_home' ), 'section_aloct_1', 'section_id' );

    }


    /* инициализируем меню в админке*/
    public static function add_admin_menu() {

        $hello1 = __( 'Add link on copied text settings', 'add-link-on-copied-text' );
        add_options_page( ' ', $hello1, 'manage_options', 'aloct-plugin-options', array( 'AddLinkOnCopiesText', 'aloct_plugin_options' ) );
    }

    public static function aloct_plugin_options() {
        ?>
        <div class="wrap">

            <h2><?php echo _e( 'Add Link On Copied Text', 'add-link-on-copied-text' ), ' V', ALOCT_VERSION; ?></h2>

            <hr>


            <form action="options.php" method="POST">
                <?php
                settings_fields( 'option_group_aloct' );     // скрытые защитные поля
                do_settings_sections( 'section_aloct_1' ); // секции с настройками (опциями). У нас она всего одна 'section_id'
                submit_button();
                ?>
            </form>

        </div>
        <?php
    }


    public static function text_before_link() {
        $val = get_option( 'aloct_option' );
        if(isset( $val['text_before_link'])){ $val = $val['text_before_link'];}else{ $val= '';}
        ?>
        <input type="text" placeholder="Read more here:" name="aloct_option[text_before_link]" value="<?php echo esc_attr( $val ) ?>" />
        <br><small><?php echo __( 'If you leave the field blank, a link without text will be inserted.', 'add-link-on-copied-text' ); ?></small>
        <?php
    }

    /*The number of indents after the copied text.*/
    public static function number_indents() {
        $val = get_option( 'aloct_option' );
        if(isset( $val['number_indents'])){ $val = $val['number_indents'];}else{ $val=2;}
        ?>
        <input type="number" placeholder="2" name="aloct_option[number_indents]" value="<?php echo esc_attr( $val ) ?>" />
        <br><small><?php echo __( 'If 0 is selected, the link will appear on the same line as the text.', 'add-link-on-copied-text' ); ?></small>
        <?php
    }



    ## ссылка на главную
public static function in_home() {
        $val = get_option( 'aloct_option' );
        $checked = isset($val['only_home']) ? "checked" : "";
        ?>
        <input name="aloct_option[only_home]" type="checkbox" value="1" <?php echo $checked; ?>>
    <br><small><?php echo __( 'If enabled, the link will be inserted to the main page: https://your-domain.com. Default: to the page where the text is copied from.', 'add-link-on-copied-text' ); ?></small>

<?php }



    ## Очистка данных
    public static function sanitize_callback( $options ) {
        // очищаем
        foreach ( $options as $name => & $val ) {
            $val = strip_tags( $val );
        }

        return $options;
    }

}