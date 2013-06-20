TinyBBS
=======

TinyBBS is an tiny object-oriented forum. The challenge was to build a fully
working forum in under 150 lines of code. The product is 5kb in weight.

Due to its small size, it doesn't track users and filters spam very crudely. However,
it could easily be extended to do something useful despite being a proof of concept.

To include the forum in a page, all you need to do is this:

    <?php
        require('tinybbs.php');
    ?>
    
index.php already does that, and styles the posts adequately with css.css
