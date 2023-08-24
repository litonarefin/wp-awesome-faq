<?php
#-----------------------------------------------------------------
# Columns
#-----------------------------------------------------------------

$jw_faq_shortcode = array();


$cats = array(__('All Categories', 'wp-awesome-faq'));
foreach(get_terms('faq_cat', 'orderby=count&hide_empty=0&post_type=faq') as $term ){
    $cats[$term->slug] = $term->name;
}

$tags = array(__('All Tags', 'wp-awesome-faq'));
foreach(get_terms('faq_tags', 'orderby=count&hide_empty=0') as $term ){
    $tags[$term->slug] = $term->name;
}

// Custom FAQ
$jw_faq_shortcode['faq'] = array( 
    'type'=>'radios', 
    'title'=>__('FAQ Shortcode', 'wp-awesome-faq'),
    'attr'=>array(

        'cat'=>array(
            'type'=>'select', 
            'title'=> __('Category', 'wp-awesome-faq'), 
            'values'=> $cats
        ),        
        'tag'=>array(
            'type'=>'select', 
            'title'=> __('Tags', 'wp-awesome-faq'), 
            'values'=> $tags
        ),
        'items'=>array(
            'type'=>'text', 
            'title'=> __('Number Of Posts', 'wp-awesome-faq'), 
            'value'=> '-1'
        ),        
        'order'=>array(
            'type'=>'select', 
            'title'=> __('Order', 'wp-awesome-faq'), 
            'values'=>array(
                'DESC'=>'Descending',
                'ASC'=>'Ascending',
                )
            )
        )
);