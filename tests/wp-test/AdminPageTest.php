<?php

class AdminPageTest extends WP_UnitTestCase {
    function setAdminUser() {
        wp_set_current_user(self::factory()->user->create([
            'role' => 'administrator',
        ]));
    }

    function testItShouldHaveASettingsMenuEntry() {
        global $current_screen;
        global $menu;

        wp_set_current_user(self::factory()->user->create([
            'role' => 'administrator',
        ]));

        $this->assertFalse(is_admin());
        $current_screen = WP_Screen::get('admin_init');
        $this->assertTrue(is_admin());
        $this->assertNotEmpty(menu_page_url('event-data-settings'));
        print('Show and tell');
        print_r($current_screen);
        print_r($menu);



        // $this->assertTrue(has_action('plugins_loaded', 'load_sos_admin'));

        /*
        global $submenu;
            
        $this->assertFalse( isset( $submenu[ 'edit.php?post_type=sos' ] ) );
        $this->assertFalse( 
                Util::has_action( 'admin_page_sos_settings_page', 
                        $this->sos_options, 'render_settings_page' ) );
        
        $this->sos_options->register_settings_page();
        
        $this->assertTrue( isset( $submenu[ 'edit.php?post_type=sos' ] ) );
        $settings = $submenu[ 'edit.php?post_type=sos' ];
        $this->assertSame( 'Settings', $settings[ 0 ][ 0 ] );
        $this->assertSame( 'administrator', $settings[ 0 ][ 1 ] );
        $this->assertSame( 'sos_settings_page', $settings[ 0 ][ 2 ] );
        $this->assertSame( 'Common Options', $settings[ 0 ][ 3 ] );
        $this->assertTrue( 
                Util::has_action( 'admin_page_sos_settings_page', 
                        $this->sos_options, 'render_settings_page' ) );
        */
    }

    /**
     * A single example test.
     */
    function adminPageDisplays() {
        global $current_screen;

        $this->assertFalse(is_admin());

        // $this->assertTrue(has_action('plugins_loaded', 'load_sos_admin'));

        /*
        global $submenu;
            
        $this->assertFalse( isset( $submenu[ 'edit.php?post_type=sos' ] ) );
        $this->assertFalse( 
                Util::has_action( 'admin_page_sos_settings_page', 
                        $this->sos_options, 'render_settings_page' ) );
        
        $this->sos_options->register_settings_page();
        
        $this->assertTrue( isset( $submenu[ 'edit.php?post_type=sos' ] ) );
        $settings = $submenu[ 'edit.php?post_type=sos' ];
        $this->assertSame( 'Settings', $settings[ 0 ][ 0 ] );
        $this->assertSame( 'administrator', $settings[ 0 ][ 1 ] );
        $this->assertSame( 'sos_settings_page', $settings[ 0 ][ 2 ] );
        $this->assertSame( 'Common Options', $settings[ 0 ][ 3 ] );
        $this->assertTrue( 
                Util::has_action( 'admin_page_sos_settings_page', 
                        $this->sos_options, 'render_settings_page' ) );
        */
    }
}
