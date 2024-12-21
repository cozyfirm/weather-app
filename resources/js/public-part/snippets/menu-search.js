$( document ).ready(function() {
    let searchedVal = '', searching = false;

    let cleanSearch = function (){
        $(".current__search").remove();
    }

    let setSearch = function (show){
        /**
         *  When user is on mobile phone, skip homepage search, and offer global search
         */
        if(window.innerWidth <= 800) return;

        if(show){
            $(".dropdown__wrapper").removeClass('d-none');
            $(".menu__search__wrapper").addClass('focused');
        }else{
            $(".menu__search__wrapper").removeClass('focused');
            $(".dropdown__wrapper").addClass('d-none');
        }
    }

    let searchCitiesByText = function (uri, value){
        if(searching) return;

        /* Rise flag for searching */
        searching = true;

        cleanSearch();

        $.ajax({
            url: uri,
            method: 'POST',
            dataType: "json",
            data: {
                term: value
            },
            success: function success(response) {
                if(response['code'] === '0000'){
                    let data = response['data']['data'];

                    if(data.length){
                        let wrapper = $("<div>").attr('class', 'current__search skip-closing');

                        for(let i=0; i<data.length; i++){
                            wrapper.append(function (){
                                return $("<div>").attr('class', 'current__search__row skip-closing').attr('value', data[i]['id'])
                                    .append(function (){
                                        return $("<h6>").attr('class', 'skip-closing').text(data[i]['title']);
                                    })
                                    .append(function (){
                                        return $("<p>").attr('class', 'skip-closing').text(data[i]['description']);
                                    })
                            });
                        }

                        $(".searched__items__inside").prepend(function (){
                            return wrapper;
                        });
                    }
                }else{
                    cleanSearch();
                }

                searching = false;
            }
        });
    };

    let preSearch = function (uri, value){
        if(value.length >= 2){
            /* Hide previous search */
            $(".menu__last__search").addClass('d-none');

            searchCitiesByText(uri, value);
        }else{
            /* Remove searched elements */
            cleanSearch();

            /* Show previous search */
            $(".menu__last__search").removeClass('d-none');
        }
    }

    /**
     *  On keyup on main input field
     */
    $("body").on('keyup', '#menu-search', function(e) {
        if(e.key === "Enter") {
            if($(this).val() === '' || $(this).val() === ' ') return;

            window.location = '/forecast/search/' + $(this).val();
            return;
        }

        preSearch($(this).attr('uri'), $(this).val());
    }).on('focus', '#menu-search', function(e) {
        setSearch(true);

        preSearch($(this).attr('uri'), $(this).val());
    }).on('focusout', '#menu-search', function(e) {
        // $("#menu-search").val("");

        // setSearch(false);
    }).on('click', '.current__search__row', function(e) {
        /**
         *  When user clicks on current city
         */

        window.location = '/forecast/preview/' + $(this).attr('value');
    }).on('click', '.last__search__row', function(e) {
        /**
         *  When user clicks on previous searched cities
         */

    }).on('click', 'body', function(e){
        if(!$(e.target).hasClass('last__search__row') ) {
            setSearch(false);
            // $(".input__search_wrapper").find(".c-select-2-wrapper").remove();
        }else{
            console.log("anywhere ..");
        }

        console.log("anywhere ..");
    });

});
