$( document ).ready(function() {
    let searchedVal = '', searching = false;

    /**
     *  On keyup on main input field
     */
    $("body").on('keyup', '#main-search', function(e) {
        searchedVal = $(this).val();

        if(searchedVal.length >= 2){
            /* Rise flag for searching */
            searching = true;

            $(".dropdown__wrapper").removeClass('d-none');
        }else{
            /* Remove searched elements */
            $(".dropdown__wrapper").addClass('d-none');
        }
    }).on('focus', '#main-search', function(e) {
        $(".dropdown__wrapper").removeClass('d-none');
    }).on('focusout', '#main-search', function(e) {
        $(".dropdown__wrapper").addClass('d-none');
    }).on('click', '.cs2-row', function(e) {

    }).on('click', 'body', function(e){
        if(!$(e.target).hasClass('c-select-2-wrapper') ) {
            $(".input__search_wrapper").find(".c-select-2-wrapper").remove();
        }else{
            // console.log("anywhere ..");
        }
    });

});
