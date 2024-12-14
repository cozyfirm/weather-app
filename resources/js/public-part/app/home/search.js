$( document ).ready(function() {
    let searchedVal = '', searching = false;

    let setSearch = function (show){
        if(show){
            $(".dropdown__wrapper").removeClass('d-none');
            $(".search__wrapper").addClass('focused');
        }else{
            $(".search__wrapper").removeClass('focused');
            $(".dropdown__wrapper").addClass('d-none');
        }
    }

    /**
     *  On keyup on main input field
     */
    $("body").on('keyup', '#main-search', function(e) {
        searchedVal = $(this).val();

        if(searchedVal.length >= 2){
            /* Rise flag for searching */
            searching = true;

            setSearch(true);
        }else{
            /* Remove searched elements */
            setSearch(false);
        }
    }).on('focus', '#main-search', function(e) {
        setSearch(true);
    }).on('focusout', '#main-search', function(e) {
        setSearch(false);
    }).on('click', '.cs2-row', function(e) {

    }).on('click', 'body', function(e){
        if(!$(e.target).hasClass('c-select-2-wrapper') ) {
            // $(".input__search_wrapper").find(".c-select-2-wrapper").remove();
        }else{
            // console.log("anywhere ..");
        }
    });

});
