<!-- 1687 -->
<!-- $tour_packages = get_post_meta( get_the_ID(), '_naiau_group_tour_package', true ); -->
<?php 
  $tabs = get_post_meta('1687','_naiau_group_tab_maker',true);
  wp_reset_postdata();
 

  

if(!empty($tabs)){ ?>
    <div id="tabs">
      <ul>
       <?php
        $counter = 1;
         foreach((array)$tabs as $tab): 
          echo '<li><a href="#tabs-'.$counter.'">'.$tab['tab_title'].'</a></li>';
          $counter++;
          endforeach; 
        ?>
      </ul>
          <?php 
            $counter = 1;
            foreach((array)$tabs as $tab): 
              $cats[0] = $tab['notify_category'];
            var_dump($cats);
              $notifies = get_posts(array(
                  'notify_cat'=>$cats,
                  'post_per_page' => 20,
                  )
              );
              wp_reset_postdata();
              var_dump($notifies);
              $tab_content =  '<div id="#tabs-'.$counter.'">';
              $tab_content .= '<ul>';
                    foreach ( $notifies as $notify ) {
                        setup_postdata( $notify );
                        $tab_content .= '<li>';
                        $tab_content .= '<a href="'.$notify.'"></a>';  
                        $tab_content .= '</li>';
                        
                    } 
              $tab_content .= '</ul>';
              $counter++;
            endforeach; 
           ?>
      
    </div>
    <script type="text/javascript" defer>
      jQuery('document').ready(function($){
          $('#tabs').tabs();
      });
    </script>
<?php } ?>