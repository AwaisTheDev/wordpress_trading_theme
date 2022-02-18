<h3>Nothing Found :(</h3>
<?php
if(current_user_can( 'publish_posts' )){
    printf(
        wp_kses(  
            __('Ready to publish your first post <a href=" %s">Get Started</a>', 'lyra'), 
            [
                'a'=>[
                    'href'=>[],
                ]
            ] 
         ),
         esc_url( admin_url('post-new.php'))
    );
}

else{
    if(is_search()){
        ?>
        <p>Nothing found matching your search keyword. Try a different keyword</p>

        <?php

        get_search_form(  );
    }

    else{
        ?>
        <h2>Page Not Found</h2>
        <p>We are not able to find something you are looking for.</p>

        <?php

        get_search_form(  'Search Now');
    }

}
