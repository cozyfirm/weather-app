import './bootstrap';

// import 'jquery-ui/ui/widgets/datepicker'; // Make sure this line is present
// import 'jquery-ui/themes/base/theme.css'; // Optional: Include the theme CSS

import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.css';
import 'bootstrap-datepicker';

/* Import Admin JavaScript data */
import './admin/layout/menu.js';
import './admin/layout/filters.js';
import './admin/snippets/c-select-2.js';

/* Import Submit script */
import "./style/submit.js";

/**
 *  Import public scripts such as:
 *      1. Auth scripts
 */

import './public-part/auth/auth.js';

$(document).ready(function() {
    $(".datepicker").datepicker({
        format: 'mm.dd.yyyy',
        autoclose: true,
    }); // Initialize the datepicker
});
