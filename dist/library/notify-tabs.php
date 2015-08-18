<!-- 1687 -->
<!-- $tour_packages = get_post_meta( get_the_ID(), '_naiau_group_tour_package', true ); -->
<?php 

  // $args = array (
  //   'post_type'              => array( 'tab' ),
  //   'posts_per_page'         => '10',
  //   'orderby'          => 'date',
  //   'order'            => 'ASC',
  //   // 'category'         => 'news_cat',
  //   'tab_cat'    => 'featured',
  // );
  // $tab = get_posts($args);
  
  $show_tabs = get_post_meta(get_the_ID(),'_naiau_show_tabs');
  $tab_id= get_post_meta(get_the_ID(),'_naiau_tab_id');
   //var_dump($tab_id);
  // var_dump(get_post_meta('1867','_naiau_group_tab',true));
  
 $tabs = get_post_meta($tab_id[0],'_naiau_group_tab');
 $tabs = $tabs[0];
 //var_dump($tabs);

  

if( !empty($tabs) && $show_tabs == true){ ?>
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
<?php } ?>