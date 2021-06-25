<?php
namespace ElementorFootnotes\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class Footnotes extends Widget_Base {
 
  /**
   * Retrieve the widget name.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget name.
   */
  public function get_name() {
    return 'footnotes';
  }
 
  /**
   * Retrieve the widget title.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget title.
   */
  public function get_title() {
    return __( 'Footnotes', 'elementor-footnotes' );
  }
 
  /**
   * Retrieve the widget icon.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget icon.
   */
  public function get_icon() {
    return 'fa fa-pencil';
  }
 
  /**
   * Retrieve the list of categories the widget belongs to.
   *
   * Used to determine where to display the widget in the editor.
   *
   * Note that currently Elementor supports only one category.
   * When multiple categories passed, Elementor uses the first one.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return array Widget categories.
   */
  public function get_categories() {
    return [ 'general' ];
  }
 
  /**
   * Register the widget controls.
   *
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function _register_controls() {
    $this->start_controls_section(
      'footnotes_section_content',
      [
        'label' => __( 'Content', 'elementor-footnotes' ),
      ]
    );

    $this->add_control(
      'footnotes_main_content',
      [
        'label' => __( 'Content', 'elementor-footnotes' ),
        'type' => Controls_Manager::WYSIWYG
      ]
    );


    $this->end_controls_section();    

    $this->start_controls_section(
      'footnotes_footnotes',
      [
        'label' => __( 'Footnotes', 'elementor-footnotes' ),
      ]
    );
    

		$repeater = new \Elementor\Repeater();    
   
    $repeater->add_control(
      'footnote_content',
      [
        'label' => __( 'Content', 'elementor-footnotes' ),
        'type' => Controls_Manager::WYSIWYG,
				'dynamic' => [
					'active' => true,
				],
        'default' => __( 'Content', 'elementor-footnotes' ),
      ]
    );    

    $repeater->add_control(
      'footnote_type',
      [
          'label' => __('Type', 'elementor-footnotes'),
          'type' => Controls_Manager::SELECT,
          'default' => 'blue',
          'options' => [
              'blue' => __('Blue', 'elementor-footnotes'),
              'yellow' => __('Yellow', 'elementor-footnotes'),
              'grey' => __('Grey', 'elementor-footnotes'),        
          ],
          'frontend_available' => true
      ]
  );

  $repeater->add_control(
    'footnote_note',
    [
      'separator' => 'before',
      'type' => \Elementor\Controls_Manager::RAW_HTML,
      'raw' => __( 'Position = -1 means after the last paragraph in the content. <br/>
      Position = 1, 2, 3, etc means after the corresponding paragraph in the content.', 'elementor-footnotes' ),
      'content_classes' => 'your-class',
    ]
  );


  $repeater->add_control(
    'footnote_position',
    [
      'label' => __( 'Position', 'elementor-footnotes' ),
      'type' => Controls_Manager::TEXT,
      'default' => __( '-1', 'elementor-footnotes' ),
    ]
  ); 


    $this->add_control(
			'footnote_list',
			[
				'label' => __( 'Repeater List', 'elementor-footnotes' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'title_field' => 'Footnote {{{ footnote_type }}}'
			]
    );
    

 
 
    $this->end_controls_section();
  }

  protected function add_footnote($dom, $footnote, $type, $position=-1) {
        $footnoteDom = new \DOMDocument();
        $footnoteDom->loadHTML($footnote);
    
        # create a link to footnotes
        $sup = $dom->createElement('sup');
        $sup->setAttribute("class", $type."-footnote-container");
        $id = rand();
        $footnote_link = $dom->createElement('a', $id);
        $footnote_link->setAttribute("href", "#fn".$type.":".$id);
        $footnote_link->setAttribute("rel", "footnote");
        $sup->appendChild($footnote_link);        

        // create footnotes text
        $footnotes = $dom->createElement('div');
        $footnotes->setAttribute("class", "footnotes");
        $ol = $dom->createElement('ol');
        $footnotes->appendChild($ol);        
        $li = $dom->createElement('li');
        $li->appendChild($dom->importNode($footnoteDom->documentElement, TRUE));
        $li->setAttribute("id", "fn".$type.":".$id);
        $li->setAttribute("class", "footnote");        
        $ol->appendChild($li);  

        $paragraphs = $dom->getElementsByTagName("p");
        if ($position==-1) {
          $paragraph = $paragraphs[$paragraphs->length-1];        
        } else {
          $paragraph = $paragraphs[$position-1];
        }     

        return array($paragraph, $sup, $footnotes);
  }
 
  /**
   * Render the widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function render() {
    $settings = $this->get_settings_for_display(); 
    $this->add_inline_editing_attributes( 'footnotes_main_content', 'advanced' ); 
    
    $content = $settings['footnotes_main_content'];
    $dom = new \DOMDocument();  
    $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8"));                

    $sups = array();
    if ( $settings['footnote_list'] ) {
			foreach (  $settings['footnote_list'] as $item ) {
        $footnote_content	= mb_convert_encoding($item['footnote_content'], 'HTML-ENTITIES', "UTF-8");
        array_push($sups, 
          $this->add_footnote($dom, $footnote_content, $item['footnote_type'], $item['footnote_position'])
        );
      }

      foreach ($sups as list($p, $sup, $footnote)) {
        $p->appendChild($sup);
        $dom->appendChild($footnote);
      }
    }
    echo $dom->saveHtml();
  }
}