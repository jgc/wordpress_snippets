http://stackoverflow.com/questions/772510/wordpress-filter-to-modify-final-html-output
	
WordPress doesn't have a "final output" filter, but you can hack together one. The below example resides within a "Must Use" plugin I've created for a project.

Note: I haven't tested with any plugins that might make use of the "shutdown" action.

The plugin works by iterating through all the open buffer levels, closing them and capturing their output. It then fires off the "final_output" filter, echoing the filtered content.

Sadly, WordPress performs almost the exact same process (closing the open buffers), but doesn't actually capture the buffer for filtering (just flushes it), so additional "shutdown" actions won't have access to it. Because of this, the below action is prioritized above WordPress's.

wp-content/mu-plugins/buffer.php

<?php

/**
 * Output Buffering
 *
 * Buffers the entire WP process, capturing the final output for manipulation.
 */

ob_start();

add_action('shutdown', function() {
    $final = '';

    // We'll need to get the number of ob levels we're in, so that we can iterate over each, collecting
    // that buffer's output into the final output.
    $levels = ob_get_level();

    for ($i = 0; $i < $levels; $i++)
    {
        $final .= ob_get_clean();
    }

    // Apply any filters to the final output
    echo apply_filters('final_output', $final);
}, 0);
An example of hooking into the final_output filter:

<?php

add_filter('final_output', function($output) {
    return str_replace('foo', 'bar', $output);
});
