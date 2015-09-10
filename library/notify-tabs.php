<!-- 1687 -->
<!-- $tour_packages = get_post_meta( get_the_ID(), '_naiau_group_tour_package', true ); -->
<?php 

    
  $show_tabs = get_post_meta(get_the_ID(),'_naiau_show_tabs');
  
 
if($show_tabs == true){ 

  $tab_id= get_post_meta(get_the_ID(),'_naiau_tab_id');
  $tabs = get_post_meta($tab_id[0],'_naiau_group_tab');
  $tabs = $tabs[0];

  if( !empty($tabs)){
?>

<div class="notify-tabs-wrap">
        <section class="layout">
    <div id="tabs">
      <ul>
       <?php
        $counter = 1;
         foreach((array)$tabs as $tab): 
          echo '<li><a href="#tabs-'.$counter.'">'.$tab['tab_name'].'</a></li>';
          $counter++;
          endforeach; 
        ?>
      </ul>
          <?php 
            $counter = 1;
            foreach((array)$tabs as $tab): 

                        $content_post = get_post($tab['tab_id']);
                        $content = $content_post->post_content;
                        $content = apply_filters('the_content', $content);
                        $content = str_replace(']]>', ']]&gt;', $content);

              


            
              $tab_content = ""; 
              $tab_content .=  '<div id="tabs-'.$counter.'">';
              $tab_content .= '<ul class="notifies-list">';
              $tab_content .= $content;
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
<?php wp_reset_postdata();

} ?>
<?php } ?>