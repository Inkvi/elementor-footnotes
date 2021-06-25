<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

class Footnotes_Section
{

    public function __construct()
    {
        add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'register_controls' ], 10 );
        add_action( 'elementor/widget/render_content', array( $this, 'render_content' ), 10, 2 );                 
    }

    public function get_name()
    {
        return 'footnote-section';
    }

    public function register_controls($element)
    {

        $element->start_controls_section(
            'footnote_section',
            [
                'label' => __('Footnote', 'elementor-footnotes'),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'footnote_section_enable',
            [
                'label' => __('Enable Footnote', 'elementor-footnotes'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        
        $element->add_control(
            'footnote_section_content',
            [
                'label' => __('Content', 'elementor-footnotes'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __('I am a tooltip', 'elementor-footnotes'),
                'dynamic' => ['active' => true],
                'frontend_available' => true,
                'condition' => [
                    'footnote_section_enable!' => '',
                ],
            ]
        );

        $element->add_control(
            'footnote_section_type',
            [
                'label' => __('Type', 'elementor-footnotes'),
                'type' => Controls_Manager::SELECT,
                'default' => 'blue',
                'options' => [
                    'blue' => __('Blue', 'elementor-footnotes'),
                    'yellow' => __('Yellow', 'elementor-footnotes'),
                    'grey' => __('Grey', 'elementor-footnotes'),        
                ],
                'frontend_available' => true,
                'condition' => [
                    'footnote_section_enable!' => '',
                ],
            ]
        );

        $element->end_controls_section();

    }

    public function render_content ($content, $element) {        
        $settings = $element->get_settings_for_display();        

        if ($settings['footnote_section_enable'] != 'yes') {
            return $content;
        }

        $footnoteDom = new DOMDocument();
        $footnoteDom->loadHTML($settings['footnote_section_content']);
        
        $dom = new DOMDocument();
        $dom->loadHTML($content);  
        
        # create a link to footnotes
        $sup = $dom->createElement('sup');
        $sup->setAttribute("class", $settings['footnote_section_type']."-footnote-container");
        $footnote_link = $dom->createElement('a', "1");
        $footnote_link->setAttribute("href", "#fn".$settings['footnote_section_type'].":1");
        $footnote_link->setAttribute("rel", "footnote");
        $sup->appendChild($footnote_link);

        // create footnotes text
        $footnotes = $dom->createElement('div');
        $footnotes->setAttribute("class", "footnotes");
        $ol = $dom->createElement('ol');
        $footnotes->appendChild($ol);        
        $li = $dom->createElement('li');
        $li->appendChild($dom->importNode($footnoteDom->documentElement, TRUE));
        $li->setAttribute("id", "fn".$settings['footnote_section_type'].":1");
        $li->setAttribute("class", "footnote");        
        $ol->appendChild($li);

        
        $outerDiv = $dom->getElementsByTagName("div")[0];
        $paragraphs = $outerDiv->getElementsByTagName("p");
        $paragraph = $paragraphs[$paragraphs->length-1];        
        $paragraph->appendChild($sup);
        $outerDiv->appendChild($footnotes);

        return $dom->saveHtml();
    }   
}

new Footnotes_Section();
