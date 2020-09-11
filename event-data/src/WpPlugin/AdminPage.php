<?php

declare(strict_types=1);

namespace EventData\WpPlugin;

abstract class AdminPage {

    /** @var string The capability required to access this page. */
    protected $capability = 'manage_options';

    /** @var Plugin The parent plugin (set by the constructor). */
    protected $plugin;

    /**
     * @var string The text to be shown in the admin menu (if not set will be
     *             based on the plugin name by the constructor).
     */
    protected $menuLabel;

    /** @var string The parent for the entry in the Admin menu. */
    protected $menuParent;

    /** @var string The slug for the page (will be prefixed by the constructor). */
    protected $pageSlug;

    /**
     * @var string The text to be shown as the page <title> and <h1> heading (if
     *             not set will be based on the plugin name by the constructor).
     */
    protected $pageTitle;

    /** @var string The name of the template to render. */
    protected $template;

    /** @var array Template variables. */
    protected $templateVars = [];

    // Public methods ------------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @param Plugin The parent plugin.
     */
    public function __construct($plugin) {
        // Save the plugin in case it is needed later.
        $this->plugin = $plugin;

        // Prefix the page slug with the plugin slug.
        $this->pageSlug = $plugin->slugify($this->pageSlug ?? 'settings');

        // Set default menu label and page title if these have not been set.
        if ($this->menuLabel === null) {
            $this->menuLabel = $plugin->getName();
        }
        if ($this->pageTitle === null) {
            $this->pageTitle = $plugin->getName() . ' Settings';
        }

        // Set template variables.
        $this->templateVars = array_merge([
            'pageSlug' => $this->pageSlug,
            'pageTitle' => $this->pageTitle,
        ], $this->templateVars);

        // Register admin hooks.
        $this->addMenuEntry();
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }

    public function enqueue_admin_scripts($hook) {
        if ('settings_page_api-data-admin' != $hook) return;
        wp_enqueue_style( 'tabulator-css', plugin_dir_url( dirname(__FILE__) ) . 'assets/tabulator.min.css');
        wp_enqueue_script( 'tabulator', plugin_dir_url( dirname(__FILE__) ) . 'assets/tabulator.min.js');
    }

    /**
     * Render the page.
     *
     * Invoked as a callback when the related admin menu item is selected.
     */
    public function render(): void {
        if (!current_user_can($this->capability)) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        $this->plugin->render($this->template, array_merge($this->templateVars, [
            'messagesSlug' => $this->plugin->slugify('messages'),
        ]));
    }

    // Protected methods ---------------------------------------------------------------------------

    /**
     * Add a admin menu entry for the page.
     */
    protected function addMenuEntry(): void {
        // Set up the arguments for the call to the WP function.
        $args = [
            $this->pageTitle,
            $this->menuLabel,
            $this->capability,
            $this->pageSlug,
            [$this, 'render'],
        ];

        // Call the appropriate WP function.
        switch ($this->menuParent) {
            case 'settings':
                call_user_func_array('add_options_page', $args);
                break;
            default:
                call_user_func_array('add_menu_page', $args);
        }
    }

    // Refactor after here -------------------------------------------------------------------------

    protected $settingsGroups = [];
    protected $groups = [];
    protected $sections;

    /**
     *
     * @param mixed[] $sections An array of sections. Each section is an array:
     * - `string 'id'` The id for the admin page section.
     * - `string 'title'` HTML for the section's title.
     */
    public function addSections(array $sections = []): self {
        $this->sections = $sections;
        add_action('admin_init', [$this, 'addSectionsCallback']);
        add_action('admin_init', [$this, 'addFieldsCallback']);
        return $this;
    }

    public function addSectionsCallback(): void {
        foreach ($this->sections as $section) {
            add_settings_section(
                $section['id'],
                $section['title'] ?? null,
                [$this, 'renderSection'],
                $this->settings['pageSlug']
            );
        }
    }

    /**
     *
     * @param mixed[] $sections An array of sections. Each section is an array:
     * - `string 'id'` The id for the admin page section.
     * - `string 'title'` HTML for the section's title.
     */
    public function addFieldsCallback() {
        foreach ($this->sections ?? [] as $section) {
            foreach ($section['fields'] ?? [] as $field) {
                // Group names by option group and prefix.
                $group = $field['group'] = $field['group'] ?? $section['group'];
                $this->groups[$group] = true;
                $group = $this->plugin->slugify($group, '_');
                $field['key'] = $field['key'] ?? $field['id'];
                $field['name'] = "{$group}[{$field['key']}]";

                // Use label_for in preference to id (since WP 4.6).
                $field['label_for'] = $field['id'] = "{$group}-{$field['id']}";
                add_settings_field(
                    $field['id'],
                    $field['label'],
                    [$this, 'renderField'],
                    $this->settings['pageSlug'],
                    $section['id'],
                    $field
                );
            }
        }
        // Should refactor the whole thing to better integrate the settings and options APIs.
        foreach (array_keys($this->groups) as $group) {
            $optionName = $this->plugin->slugify($group, '_');

            $settingsGroup = $this->settingsGroups[$group] ?? null;

            if ($settingsGroup) {
                register_setting(
                    // Option group.
                    $this->settings['pageSlug'],
                    // Option name.
                    $optionName,
                    [
                        'type' => 'array',
                        'sanitize_callback' => $settingsGroup['validate'],
                    ]
                );
            } else {
                register_setting($this->settings['pageSlug'], $optionName);
            }

            $this->values[$group] = get_option($optionName);
        }
    }

    /**
     * @see https://www.smashingmagazine.com/2016/04/three-approaches-to-adding-configurable-fields-to-your-plugin/
     */
    public function renderField($field) {
        if (is_array($this->values[$field['group']])) {
            $value = $this->values[$field['group']][$field['key']] ?? null;
        } else {
            $value = null;
        }

        // Check which type of field we want
        switch ($field['type'] ?? null) {
            case 'textarea': // If it is a textarea
                printf(
                    '<textarea name="%1$s" id="%2$s" placeholder="%3$s" rows="%5$s"'
                        . ' cols="50">%4$s</textarea>',
                    $field['name'],
                    $field['id'],
                    $field['placeholder'],
                    $value,
                    $field['rows'] ?? 5
                );
                break;
            case 'select': // If it is a select dropdown
                if (!empty($field['options']) && is_array($field['options'])) {
                    $options_markup = '';
                    foreach ($field['options'] as $key => $label) {
                        $options_markup .= sprintf(
                            '<option value="%s" %s>%s</option>',
                            $key,
                            selected($value, $key, false),
                            $label
                        );
                    }
                    printf(
                        '<select name="%1$s" id="%2$s">%3$s</select>',
                        $field['name'],
                        $field['id'],
                        $options_markup
                    );
                }
                break;
            case 'html': // Just render the html
                echo($field['html']);
                break;
            case 'text': // If it is a text field
            default:
                $width = isset($field['width']) ? ' style="width:' . $field['width'] . 'px"' : '';
                $size = isset($field['size']) ? ' size="' . $field['size'] . '"' : '';
                printf(
                    '<input name="%1$s" id="%2$s" type="%3$s" placeholder="%4$s"'
                        . ' value="%5$s"' . $size . $width . '/>',
                    $field['name'],
                    $field['label_for'],
                    $field['type'] ?? 'text',
                    $field['placeholder'] ?? null,
                    $value
                );
        }

        // If there is help text
        if ($helper = $field['helper'] ?? null) {
            printf('<span class="helper"> %s</span>', $helper); // Show it
        }

        // If there is supplemental text
        if ($supplemental = $field['supplemental'] ?? null) {
            printf('<p class="description">%s</p>', $supplemental); // Show it
        }
    }

    public function renderSection($section) {
        $this->plugin->render($this->settings['sectionTemplate'], array_merge($this->templateVars, $section));
    }
}
