<!-- 1687 -->
<!-- $tour_packages = get_post_meta( get_the_ID(), '_naiau_group_tour_package', true ); -->
<?php 

  $args = array (
    'post_type'              => array( 'tab' ),
    'posts_per_page'         => '10',
    'orderby'          => 'date',
    'order'            => 'ASC',
    // 'category'         => 'news_cat',
    'tab_cat'    => 'featured',
  );
  $tabs = get_posts($args);
  $notify_show = get_post_meta(get_the_ID(),'_naiau_notify_tabs');
  // var_dump($tabs);
  // var_dump(get_post_meta('1867','_naiau_group_tab',true));
  
 

  

if(!empty($tabs) && $notify_show == true){ ?>
<div class="notify-tabs-wrap">
        <section class="layout">
    <div id="tabs">
      <ul>
       <?php
        $counter = 1;
         foreach((array)$tabs as $tab): 
          echo '<li><a href="#tabs-'.$counter.'">'.$tab->post_title.'</a></li>';
          $counter++;
          endforeach; 
        ?>
      </ul>
          <?php 
            $counter = 1;
            foreach((array)$tabs as $tab): 
              $notify_ids = get_post_meta($tab->ID,'_naiau_group_tab');


            
              $tab_content = ""; 
              $tab_content .=  '<div id="tabs-'.$counter.'">';
              $tab_content .= '<div class="tab-content">'.$tab->post_content.'</div>';
              $tab_content .= '<ul class="notifies-list">';
                    $n_ids = $notify_ids[0];
                    foreach ( $n_ids as $n_id ) {
                       
                        $notify_id = $n_id['notify_id'];
                        $tab_content .= '<li>';
                        $tab_content .= '<a href="'.get_the_permalink($notify_id).'">'.get_the_title($notify_id).'</a>';  
                        $tab_content .= '</li>';
                        
                    } 
              $tab_content .= '</ul></div>';
              echo $tab_content;
              $counter++;
            endforeach; 

           ?>
      
    </div>
    <script type="text/javascript" defer>
      jQuery('document').ready(function($){
          $('#tabs').tabs();
      });
    </script>
  </section>
</div>
<?php } ?>