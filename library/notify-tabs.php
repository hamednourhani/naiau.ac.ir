<!-- 1687 -->
<!-- $tour_packages = get_post_meta( get_the_ID(), '_naiau_group_tour_package', true ); -->
<?php 

  $args = array (
    'post_type'              => array( 'tab' ),
    'posts_per_page'         => '15',
    // 'category'         => 'news_cat',
    'tab_cat'    => 'front',
  );
  $tabs = get_posts($args);
  // var_dump($tabs);
  // var_dump(get_post_meta('1867','_naiau_group_tab',true));
  
 

  

if(!empty($tabs)){ ?>
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

            
              
              $tab_content =  '<div id="tabs-'.$counter.'">';
              $tab_content .= '<ul class="notifies-list">';
                    foreach ( $notify_ids as $notify_id ) {
                        $n_id = $notify_id[0]['notify_id'];
                        $tab_content .= '<li>';
                        $tab_content .= '<a href="'.get_the_permalink($n_id).'">'.get_the_title($n_id).'</a>';  
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